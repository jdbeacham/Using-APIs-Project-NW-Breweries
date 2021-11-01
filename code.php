<?php
session_start();
?>
<meta charset="UTF-8">
<?php

/* Get latitude and longitude from Google */

if (isset($location) || $myLocation == "yes") {
    $nwcArray=$_SESSION['nwcArray'];
if (isset($location)) {
$locURL = "https://maps.googleapis.com/maps/api/geocode/json?address=,$regexlocation,&key=AIzaSyAQS-8sYRq5oEtfnYpOnKo49zW-dzVP7pI";
$channel = curl_init();
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
curl_setopt($channel, CURLOPT_URL, $locURL);
$result = curl_exec($channel);
$googleData = json_decode($result, true);
curl_close($channel);

$lat = ($googleData["results"][0]["geometry"]["location"]["lat"]);
$lng = ($googleData["results"][0]["geometry"]["location"]["lng"]);
}

if ($myLocation == "yes") {
    $lat = $_GET["latitude"];
    $lng = $_GET["longitude"];
    }

/* Filtering for breweries within 10 miles of location factoring for the curve of the earth */

$R = 3950;
$r = 10;

$maxLat = $lat + rad2deg($r/$R);
$minLat = $lat - rad2deg($r/$R);
$maxLng = $lng + rad2deg(asin($r/$R) / cos(deg2rad($lat)));
$minLng = $lng - rad2deg(asin($r/$R) / cos(deg2rad($lat)));

$listArray = array();
for ($i = 0; $i < count($nwcArray); $i++) {
    if ($minLng < $nwcArray[$i]["longitude"] && $maxLng > $nwcArray[$i]["longitude"]
    && $minLat < $nwcArray[$i]["latitude"] && $maxLat > $nwcArray[$i]["latitude"] ) {
        array_push($listArray, $nwcArray[$i]);
    }
}

for ($i = 0; $i < count($listArray); $i++) {

$distanceLat = deg2rad($listArray[$i]["latitude"] - $lat);
$distanceLng = deg2rad($listArray[$i]["longitude"] - $lng);

$a = sin($distanceLat/2) * sin($distanceLat/2) + cos(deg2rad($lat)) * cos(deg2rad($listArray[$i]["latitude"])) * sin($distanceLng/2)
 * sin($distanceLng/2);
$c = 2 * asin(sqrt($a));
$d = $R * $c;
$listArray[$i]["haverdistance"] = $d;
}

/* Sort breweries by distance */

function sort_array($a,$b) {
    if ($a["haverdistance"] == $b["haverdistance"])
    return 0;
    if ($a["haverdistance"] < $b["haverdistance"])
    return -1;
    else return 1;
}
usort($listArray, "sort_array");
array_splice($listArray,21);

/* Get google distance for display */

    for ($i = 0; $i < count($listArray); $i++) {
        $latitude = $listArray[$i]['latitude'];
        $longitude = $listArray[$i]['longitude'];
        $locURL = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$lat%2C$lng&destinations=$latitude%2C$longitude&key=AIzaSyAQS-8sYRq5oEtfnYpOnKo49zW-dzVP7pI";
$channel = curl_init();
curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
curl_setopt($channel, CURLOPT_URL, $locURL);
$result = curl_exec($channel);
$googleDistance = json_decode($result, true);
$listArray[$i]['distance'] = $googleDistance["rows"][0]["elements"][0]["distance"]["text"];
curl_close($channel);
    }
usort($listArray, "sort_array_again");
$chunked_list = array_chunk($listArray,5);
$_SESSION["placeList"] = array();
$_SESSION["placeList"] = $chunked_list;
}

/* Sort again after google distances -- from usort function above -- */

function sort_array_again($a,$b) {    
    if (floatval($a["distance"]) == floatval($b["distance"]))
    return 0;
    if (floatval($a["distance"]) < floatval($b["distance"]))
    return -1;
    else return 1;
}
?>
