<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('BlessBox');
$decoder->sethexString('0a00ff0f0200030005000400204e0000204e00002400010a420072007500630065001e00000028000000320000003c00000046000000500000005a000000640000006e00000002000100d40700000000000002000000412b00000a0000001528000005000000');
$result = $decoder->decode();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);