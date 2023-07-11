<?php

require __DIR__ . '/../vendor/autoload.php';

$mask = 1;

$decoder = new App\Decoder();
$decoder->guessItemType($mask);
$decoder->sethexString('5a00ff001001000031000000b4610000786900002c00040a4200720075006300650000000000090000000b00000000000000930200009b0500000000000000000000180000000000604000000000010000000000000003000000114500009200000001000000f02300004d000000cf2500000e000000');
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);