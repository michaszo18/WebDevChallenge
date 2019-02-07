<?php

// $url = 'https://helion.pl/'; //adres żądania, domyślnie GET
// $ch = curl_init($url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// echo $result = curl_exec($ch);
// curl_close($ch);

$url = 'https://enmic1fji5x3n.x.pipedream.net/';
$data = [
    'name' => 'Jan',
    'email' => "jan@wp.pl"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);
