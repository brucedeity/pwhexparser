<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Bible');
$decoder->sethexString('');
$result = $decoder->decode();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);