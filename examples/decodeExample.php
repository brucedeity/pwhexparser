<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Weapon');
$decoder->sethexString('0100ff02050000000000030078050000780500002c00010000000000240100000000000000000000030000000300000005000000050000001000000000004040000000000000000000000000');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);