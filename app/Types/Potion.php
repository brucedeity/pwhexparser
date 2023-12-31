<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Potion extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'amount' => 'int8',
            'time' => 'int8',
            'recharge_time' => 'int8',
            'level' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
