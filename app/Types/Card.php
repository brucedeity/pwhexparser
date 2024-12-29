<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Card extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'type' => 'INT64_SIZE',
            'class' => 'INT64_SIZE',
            'level' => 'INT64_SIZE',
            'leadership' => 'INT64_SIZE',
            'max_level' => 'INT64_SIZE',
            'current_level' => 'INT64_SIZE',
            'current_exp' => 'INT64_SIZE',
            'merge_times' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 64;
    }
}
