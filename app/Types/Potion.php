<?php

namespace App\Types;


use App\Contracts\Translatable;

class Potion extends Translatable
{
    public function getStructure(): array
    {
        return [
            'amount' => 'int8',
            'time' => 'int8',
            'recharge_time' => 'int8',
            'level' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
