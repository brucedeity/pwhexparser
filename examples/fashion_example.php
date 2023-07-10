<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Fashion');
$decoder->sethexString('1e00000092470100010a620072007500630065000000');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);