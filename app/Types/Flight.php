<?php

namespace App\Types;

use App\Contracts\Translatable;

class Flight extends Translatable
{
    public function getStructure(): array
    {
        return [
            'fuel1' => 'int8',
            'fuel2' => 'int8',
            'level' => 'int',
            'grade' => 'int',
            'class' => 'int8',
            'time_per_element' => 'int8',
            'speed1' => 'float',
            'speed2' => 'float',
            'item_flag' => 'int',
            'crc' => 'int8',
        ];
    }

    public function getExtraStructure() : array
    {
        return [
            'level' => 'int8',
            'mana_consumption' => 'int8',
            'mana_per_second' => 'int8',
            'speed_increase' => 'float',
            'reserved' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 63;
    }
}
