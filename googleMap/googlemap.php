<?php
/**
 * Created by PhpStorm.
 * User: shahzadmiraj
 * Date: 2019-10-16
 * Time: 12:59
 */

//AIzaSyChgE_h_1b7aA-1jYZmUu--pBph99HUU40

?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="map"></div>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 31.5204, lng: 74.3587},
            zoom: 8
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIkcpPH4bMOOXYmFfpcMWl0nFSoqBQ_OI&callback=initMap"
        async defer></script>
</body>
</html>
