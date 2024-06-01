<?php

namespace App\Types;


use App\Contracts\Translatable;

class Card extends Translatable
{
    public function getStructure(): array
    {
        return [
            'type' => 'int8',
            'class' => 'int8',
            'level' => 'int8',
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
