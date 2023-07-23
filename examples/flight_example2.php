<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Flight');
$decoder->sethexString('0100000000000000020000000000000003000000');  // Special Winged Elf Flight id 2096
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);