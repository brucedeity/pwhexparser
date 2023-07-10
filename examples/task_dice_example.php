<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('TaskDice');
$decoder->sethexString('bd780000');
$decoder->validateHex();
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);