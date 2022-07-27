<?php
function getAddress($latitude, $longitude)
{
    $apiKey="331758d5fa244497a403be660f078241";
    $url = "https://api.geoapify.com/v1/geocode/reverse?lat=$latitude&lon=$longitude&apiKey=$apiKey";    
    try {
        $geocode = file_get_contents($url);
        $json = json_decode($geocode);
        $address = $json->features[0]->properties->formatted;
      } catch(Exception $e) {
        $address="Address is not availaible now";
      }
      finally{
        return $address;
      }
}