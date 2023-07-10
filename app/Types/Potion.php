<?php

namespace App\Types;

use App\Interfaces\Item;

class Potion implements Item
{
    public function getStructure(): array
    {
        return [
            'amount' => 'lint',
            'time' => 'lint',
            'recharge_time' => 'lint',
            'level_requirement' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
