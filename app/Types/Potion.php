<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Potion extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'amount' => 'INT64_SIZE',
            'time' => 'INT64_SIZE',
            'recharge_time' => 'INT64_SIZE',
            'level' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 32;
    }
}
