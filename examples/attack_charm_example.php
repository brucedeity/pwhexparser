<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('AttackCharm');
$decoder->sethexString('01000e000f002c01');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);