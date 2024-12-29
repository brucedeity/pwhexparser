<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Potion extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'amount' => 'int64',
            'time' => 'int64',
            'recharge_time' => 'int64',
            'level' => 'int64',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
