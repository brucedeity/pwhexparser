<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Flight extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'fuel1' => 'int64',
            'fuel2' => 'int64',
            'level' => 'int32',
            'grade' => 'int32',
            'class' => 'int64',
            'time_per_element' => 'int64',
            'speed1' => 'float',
            'speed2' => 'float',
            'item_flag' => 'int32',
            'crc' => 'int64',
        ];
    }

    public function getExtraStructure() : array
    {
        return [
            'level' => 'int64',
            'mana_consumption' => 'int64',
            'mana_per_second' => 'int64',
            'speed_increase' => 'float',
            'reserved' => 'int64',
        ];
    }

    public function getMinimumLength() : int
    {
        return 63;
    }
}
