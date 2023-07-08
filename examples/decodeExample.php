<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';

use App\Types\Weapon;
use App\Types\Armor;

$decoder = new App\Decoder();
$result = $decoder->decodeOctets();

echo json_encode($result, JSON_PRETTY_PRINT);