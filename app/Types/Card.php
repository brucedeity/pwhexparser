<?php

namespace App\Types;

use App\Interfaces\Item;

class Card implements Item
{
    public function getStructure(): array
    {
        return [
            'type' => 'lint',
            'class' => 'lint',
            'level_requirement' => 'lint',
            'leadership' => 'lint',
            'max_level' => 'lint',
            'current_level' => 'lint',
            'current_exp' => 'lint',
            'merge_times' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 64;
    }
}
