<?php

namespace App\Types;

use App\Contracts\Item;

class Potion implements Item
{
    public function getStructure(): array
    {
        return [
            'amount' => 'int8',
            'time' => 'int8',
            'recharge_time' => 'int8',
            'level_requirement' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
