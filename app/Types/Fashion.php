<?php

namespace App\Types;

use App\Interfaces\Item;

class Fashion implements Item
{
    public function getStructure(): array
    {
        return [
            'level_req' => 'int',
            'unknow' => 'int',
            'color' => 'int',
            'gender' => 'int',
            'creator_type' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'color_mask' => 'int',
        ];
    }
}
