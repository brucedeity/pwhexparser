<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Pet');
$decoder->sethexString('0200000008000000fa000000fb280000bd540000422a00000100000014003c0046000000500000000000030000000000000000000000000000000000af0200000100000093000000020000009400000006000000');
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);