<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Charm');
$decoder->sethexString('40771b000000403f');
$result = $decoder->decode();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);