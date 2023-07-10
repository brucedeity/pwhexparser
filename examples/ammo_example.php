<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Ammo');
$decoder->sethexString('0200ff060300040005000600640000006400000014000000642100008c000000e60000000d000000110000000400e900da07000000000000000000000000000002000000e625000001000000df2100007d000000');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);