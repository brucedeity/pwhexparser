<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Flight');
$decoder->sethexString('50460000a08c000001000100ff0f0000e02e0000000070410000704101000000');
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);