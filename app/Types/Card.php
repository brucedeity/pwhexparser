<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Card extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'type' => 'int64',
            'class' => 'int64',
            'level' => 'int64',
            'leadership' => 'int64',
            'max_level' => 'int64',
            'current_level' => 'int64',
            'current_exp' => 'int64',
            'merge_times' => 'int64',
        ];
    }

    public function getMinimumLength() : int
    {
        return 64;
    }
}
