<?php

namespace App\Types;

use App\Contracts\Item;

class Card implements Item
{
    public function getStructure(): array
    {
        return [
            'type' => 'int8',
            'class' => 'int8',
            'level_requirement' => 'int8',
            'leadership' => 'int8',
            'max_level' => 'int8',
            'current_level' => 'int8',
            'current_exp' => 'int8',
            'merge_times' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 64;
    }
}
