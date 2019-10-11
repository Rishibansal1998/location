<?php
$servername = 'localhost';
$username= 'root';
$password = '';
$dbname = 'test_api';
$conn = mysqli_connect($servername, $username, $password, $dbname);


$data = mysqli_query($conn, "SELECT * FROM `locations`");

$prev_lat = '';
$prev_lng = '';
$distance = 0;

while ($location = mysqli_fetch_array($data)) {
    $lat = $location['lat'];
    $lng = $location['lng'];

    $distance_b = 0;
    if (!empty($prev_lat) && !empty($prev_lng) ) {
        $distance_a =  distance($prev_lat, $prev_lng, $lat, $lng);

        $distance_b = $distance+$distance_a;
    }
    $prev_lat = $lat;
    $prev_lng = $lng;
    $distance = $distance_b;
}

print_r($distance * 1.609344);


function distance($lat1, $lon1, $lat2, $lon2) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    }
    else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return $miles;
    }
}
