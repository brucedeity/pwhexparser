<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Genie');
$decoder->sethexString('020000000100030004000500060007000100080009000a000b000c000d00204e00000e0000000000000006000000f60301005a0a0100510a0100610a0100660a0100600a0100');
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);