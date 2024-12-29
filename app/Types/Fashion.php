<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Fashion extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'INT64_SIZE',
            'color' => 'int32',
            'gender' => 'int32',
            'creator_type' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'color_mask' => 'int32',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 20;
    }
}
