<?php
defined('BASEPATH') or exit('No direct script access allowed');

// application/libraries/Opencagedata.php

class Opencagedata
{
    protected $api_key;

    public function __construct()
    {
        $this->api_key = 'a1a58a40f4184d20843599cbefa52b28'; // Ganti dengan kunci API Anda
    }

    public function geocode($lat, $long)
    {
        $url = 'https://api.opencagedata.com/geocode/v1/json?q=' . urlencode($lat) . '+' . urlencode($long) . '&key=' . $this->api_key;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
