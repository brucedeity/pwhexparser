<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Skill');
$decoder->sethexString('030000004a040000f3e001000a0000005a040000000000000a0000009e0000000000000001000000');
$result = $decoder->decode();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);