<?php

namespace App\Types;

use App\Interfaces\Item;

class Flight implements Item
{
    public function getStructure(): array
    {
        return [
            'fuel1' => 'lint',
            'fuel2' => 'lint',
            'level_requirement' => 'int',
            'grade' => 'int',
            'class_requirement' => 'lint',
            'time_per_element' => 'lint',
            'speed1' => 'float',
            'speed2' => 'float',
            'item_flag' => 'int',
            'crc' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 63;
    }
}
