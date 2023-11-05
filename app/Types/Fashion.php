<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Fashion extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'int8',
            'color' => 'int',
            'gender' => 'int',
            'creator_type' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'color_mask' => 'int',
        ];
    }

    public function getMinimumLength() : int
    {
        return 20;
    }
}
