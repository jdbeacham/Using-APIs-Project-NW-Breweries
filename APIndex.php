<!DOCTYPE html>
<html lang="en">
<head>
    <title>Breweries in the Northwest Corner: Explore Washington, Oregon, Idaho</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="APIIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Notable&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
    </head>
<body>



<?php

if (!isset($location) || $myLocation != "yes") {

$nwcArray = array();
$washArray = array();
$oreArray = array();
$idahoArray = array();
$searchArray = array("Washington", "Oregon", "Idaho");
for ($i = 0; $i < 3; $i++) {
$url = "https://api.openbrewerydb.org/breweries/search?query=,$searchArray[$i],";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
$result = curl_exec($ch);

$unfilteredNWCArray = json_decode($result, true);
curl_close($ch);

for ($j = 0; $j < count($unfilteredNWCArray); $j++) {
    if ($unfilteredNWCArray[$j]["state"] == $searchArray[$i]) {
        array_push($nwcArray,$unfilteredNWCArray[$j]);
        if ($i == 0){
            array_push($washArray,$unfilteredNWCArray[$j]);
        }
        if ($i == 1){
            array_push($oreArray,$unfilteredNWCArray[$j]);
        }
        if ($i == 2){
            array_push($idahoArray,$unfilteredNWCArray[$j]);
        }
    }
}
}

$state = $_GET["state"];


if ($state == "Washington") {
    $randomStateKey = array_rand($washArray,5);
    $stateArray = array();
    for ($i = 0; $i < 5; $i++){
        array_push($stateArray,$washArray[$randomStateKey[$i]]);
    }
}
if ($state == "Oregon") {
    $randomStateKey = array_rand($oreArray,5);
    $stateArray = array();
    for ($i = 0; $i < 5; $i++){
        array_push($stateArray,$oreArray[$randomStateKey[$i]]);
    }
}
if ($state == "Idaho") {
    $randomStateKey = array_rand($idahoArray,5);
    $stateArray = array();
    for ($i = 0; $i < 5; $i++){
        array_push($stateArray,$idahoArray[$randomStateKey[$i]]);
    }
}



if (!isset($state)) {
session_start();
$_SESSION['nwcArray'] = $nwcArray;
$_SESSION['washArray'] = $washArray;
$_SESSION['oreArray'] = $oreArray;
$_SESSION['idahoArray'] = $idahoArray;
}
}
require_once "APIcode.php";

?>

<div id="navWrapper"><div id="icon"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 491.696 491.696" style="enable-background:new 0 0 491.696 491.696;" xml:space="preserve">
<path d="M396.86,189.696h-51.816v-8.471c16.876-12.499,27.84-32.548,27.84-55.113c0-33.43-24.055-61.349-55.764-67.356
	C307.903,24.725,276.851,0.001,240.165,0c-20.304,0.001-39.79,7.852-54.44,21.513c-5.231-1.368-10.64-2.072-16.077-2.072
	c-25.849,0-48.398,15.683-58.222,38.235c-1.34-0.079-2.687-0.118-4.037-0.118c-37.8,0-68.553,30.753-68.553,68.553
	c0,20.813,9.335,39.475,24.024,52.058v283.526c0,16.5,13.5,30,30,30h222.184c16.5,0,30-13.5,30-30v-44h51.816
	c30.878,0,56-25.122,56-56v-116C452.86,214.817,427.738,189.696,396.86,189.696z M304.331,156.665l-175.536,0v61.051
	c0,10.493-8.507,19-19,19c-10.493,0-19-8.507-19-19v-65.971c-8.393-5.452-13.959-14.902-13.959-25.634
	c0-16.847,13.706-30.553,30.553-30.553c3.792,0,7.503,0.694,11.032,2.062c5.636,2.185,11.976,1.559,17.075-1.689
	c5.099-3.248,8.348-8.728,8.751-14.759c0.889-13.307,12.046-23.731,25.401-23.731c4.356,0,8.485,1.06,12.27,3.149
	c8.375,4.622,18.88,2.297,24.523-5.427C214.409,44.256,226.701,38,240.165,38c22.277,0,40.586,17.408,41.682,39.631
	c0.251,5.1,2.545,9.885,6.365,13.274c3.819,3.39,8.842,5.104,13.936,4.744c0.884-0.062,1.578-0.09,2.183-0.09
	c16.847,0,30.553,13.706,30.553,30.553S321.178,156.665,304.331,156.665z M400.86,361.696c0,2.131-1.869,4-4,4h-51.816v-124h51.816
	c2.131,0,4,1.869,4,4V361.696z"/>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
</div>
<div class="navButtons"><a href="APIndex.php?state=Idaho">Idaho</a></div>
<div class="navButtons"><a href="APIndex.php?state=Oregon">Oregon</a></div>
<div class="navButtons"><a href="APIndex.php?state=Washington">Washington</a></div>
</div>
<center>

<?php
if (isset($state)) {
    echo '<div id="listWrapper">
    <div class="titleWrapper">5 Random ' . $state . ' Breweries</div>';
    if ($state == "Washington") {
    echo '<div class="submit" style="width: 200px;"><a href="https://washingtonbeer.com/breweries/">Bearch Washington breweries</a></div>';
    }
    if ($state == "Oregon") {
        echo '<div class="submit" style="width: 200px;"><a href="https://traveloregon.com/map/oregon/breweries/?s=">Bearch Oregon breweries</a></div>';
        }
        if ($state == "Idaho") {
            echo '<div class="submit" style="width: 200px;"><a href="https://idahobrewers.org/breweriesinidaho">Bearch Idaho breweries</a></div>';
            }
for ($i = 0; $i < 5; $i++) {
        echo  '<div class = "listingWrapper">
    <div style="font-size: 1.5em; color: seagreen;">' . $stateArray[$i]["name"] . '</div>
    <div>' . $stateArray[$i]["street"] . ' | ' . $stateArray[$i]["city"]
    . ', ' . $stateArray[$i]["state"] . '</div>
    <div class="inlineList" id="inlineListLink"><a href="' . $stateArray[$i]["website_url"] . 
        '" target="_blank" rel="noopener noreferrer">website</a></div></div>';
}
echo '</div>';
}

$listCount = 0;
$listCountNew = $_POST["countList"];
if (isset($location) || $myLocation=="yes" || isset($listCountNew)) {
    
    if (isset($listCountNew)) {
        $listCount = $listCountNew - 1;
        $chunked_list = $_SESSION["chunkedList"];
    }

    $wordArray = array("interesting", "relevant", "beered-up", "", "astonishing", "magesterial", "more", "undiscovered", "listed");
$random = rand(0,count($wordArray));

if (count($chunked_list[$listCount]) == 1) {
    $listTitle = "1 Brewery";
}
    else {
if ($listCount == 0) {
    $listTitle = count($chunked_list[$listCount]) . " Breweries";
if (count($chunked_list[$listCount]) == 0) {
    $listTitle = "Zero Breweries Found. Try Again!";
}
}
if ($listCount < 4 && $listCount > 0) {
    $word = $wordArray[$random];
    $listTitle = count($chunked_list[$listCount]) . " " . $word . " Breweries";
    
}
if ($listCount == 4) {
    $listTitle = "1 Last Brewery";
}
}

   
    echo '<div id="listWrapper">
    <div class="titleWrapper">' . $listTitle . '</div>';
for ($i = 0; $i < count($chunked_list[$listCount]); $i++) {
        echo  '<div class = "listingWrapper">
    <div style="font-size: 1.5em; color: seagreen;">' . $chunked_list[$listCount][$i]["name"] . '</div>
    <div>' . $chunked_list[$listCount][$i]["street"] . ' | ' . $chunked_list[$listCount][$i]["city"]
    . ', ' . $chunked_list[$listCount][$i]["state"] . '</div>
    <div class="inlineList">' .
        $chunked_list[$listCount][$i]["distance"] . '</div> &#9672; ';
        if (isset($chunked_list[$listCount][$i]["website_url"])) {
        echo '<div class="inlineList" id="inlineListLink"><a href="' . $chunked_list[$listCount][$i]["website_url"] . 
        '" target="_blank" rel="noopener noreferrer">website</a></div> &#9672; ';
        }
        echo '<div class="inlineList" 
        id="directionsListLink"><a href="https://www.google.com/maps/search/?api=1&query=' . $chunked_list[$listCount][$i]["street"] . '+' . $chunked_list[$listCount][$i]["city"]
        . '+' . $chunked_list[$listCount][$i]["state"] .
        '" target="_blank" rel="noopener noreferrer">directions</a></div>
        </div>';

    }
    
}





if (isset($location) || $myLocation=="yes" || isset($listCountNew)) {
echo '<div id="nextWrapper">';
for ($i = 1; $i <= count($chunked_list); $i++) {
    echo '<div class="buttons">
    <form action="APIndex.php" method="post">
    <input class="listButtons" type="submit" name="countList" value="' . $i . '">
    </form>
    </div>';
}
echo '</div></div>';
}

?>

<div id="mainWrapper">
<div class="titleWrapper">Breweries<br>of the<br>NorthWest Corner</div>
<div class="subTitle">Explore in Washington, Oregon, Idaho</div>

<div id="myLocationWrapper">
<button onclick="getLocation()">Use My Location</button>
</div>
<div id="formWrapper">
<form action="APIndex.php" method="post">
<input type="text" style="padding: 5px; color: seagreen; font-family: 'Fjalla One', sans-serif;" name="location" placeholder="Zip or City, State">
<input class = "submit" type="submit" value="Bearch">
</form>

</div></div>


<div id="mapWrapper"></div>
</div>
</center>

<script>
function getLocation(){

    navigator.geolocation.getCurrentPosition(showPosition);
function showPosition(position) {
    let latitude=position.coords.latitude;
    let longitude=position.coords.longitude;
    window.location.replace("https://jb-codes.com/api/APIndex.php?myLocation=yes&latitude=" + latitude + "&longitude=" + longitude);
}
}



</script>



    </body>
</html>

