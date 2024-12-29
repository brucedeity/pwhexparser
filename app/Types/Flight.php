<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Flight extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'fuel1' => 'INT64_SIZE',
            'fuel2' => 'INT64_SIZE',
            'level' => 'int32',
            'grade' => 'int32',
            'class' => 'INT64_SIZE',
            'time_per_element' => 'INT64_SIZE',
            'speed1' => 'float',
            'speed2' => 'float',
            'item_flag' => 'int32',
            'crc' => 'INT64_SIZE',
        ];
    }

    public function getExtraStructure() : array
    {
        return [
            'level' => 'INT64_SIZE',
            'mana_consumption' => 'INT64_SIZE',
            'mana_per_second' => 'INT64_SIZE',
            'speed_increase' => 'float',
            'reserved' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 63;
    }
}
