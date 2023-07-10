<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Weapon');
$decoder->sethexString('64002000360000002e0100008c7b0000007d00002c000406480075007a0002000000c55c00000f00000000000000ad02000004040000000000000000000010000000000020400000000002000900d0070000d007000005000000db21000003000000852500005e010000cc25000012000000e1a1000064000000e1a1000064000000');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);