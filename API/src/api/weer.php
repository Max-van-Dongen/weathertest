<?php

header('Content-Type: application/json; charset=utf-8');
$location = $_GET["plaats"];

$ch = curl_init();

// Set the URL and other options for the cURL session
curl_setopt($ch, CURLOPT_URL, "http://api.weatherapi.com/v1/current.json?key=477c5508daea4eb0a05201914221512&q=$location&aqi=no");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);

// Execute the cURL session and get the response
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Display the response
echo $response;