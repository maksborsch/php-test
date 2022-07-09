<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
include 'DbConnect.php';

$idKey = "";
$objDb = new DbConnect;
$conn = $objDb->connect();

$apiKey = "Yhfm1ZwzDuXROatGqDUHr2eVlHU2GfIE";
$cityId = $_POST['cityId'];
$apiUrl = "http://dataservice.accuweather.com/locations/v1/cities/autocomplete?apikey=" . $apiKey . "&q=" . $cityId;
$apiUrlWeather = "http://dataservice.accuweather.com/currentconditions/v1/" . $idKey . "?apikey=" . $apiKey;

if (isset($_POST['cityId'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    if ($e = curl_error($ch)) {
        echo $e;
    } else {
        $data = json_decode($response, true);
        //    print_r($data);
    }
    curl_close($ch);
}
foreach ($data as $result) {
    $localizedName = $result["LocalizedName"];
    $idKey = $result["Key"];
    $q = $conn->query("SELECT * FROM cities WHERE idKey='$idKey' ");
    if (!$q || $q->rowCount() > 0) {
        echo "";
    } else {
        $conn->query("INSERT INTO cities (LocalizedName, idKey) VALUES ('$localizedName',
			'$idKey')");
    }
}

if (isset($_POST['idKey'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrlWeather);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    if ($e = curl_error($ch)) {
        echo $e;
    } else {
        $data = json_decode($response, true);
        print_r($data);
    }
    curl_close($ch);
}
?>
<body>
    <div class="report-container">
        <form method="POST" action="">
            Enter you location: <input type="text" name="cityId">
            <input type="submit" value="submit">
        </form>
        <?php foreach ($data as $d) { ?>
            <input type="submit" name="idKey" value="<?php echo $d["LocalizedName"]; ?>, <?php echo $d["Country"]["LocalizedName"]; ?>">
            <input type="hidden" value="<?php echo $d['idKey'] ?>">
            <!-- <div><?php echo $d["Key"]; ?></div> -->

        <?php
        }
        ?>
        <!-- <div><?php echo $data["WeatherText"]; ?></div> -->

    </div>
</body>

</html>
