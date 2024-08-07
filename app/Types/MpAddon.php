<?php

namespace App\Types;


use App\Contracts\Translatable;

class MpAddon extends Translatable
{
    public function getStructure(): array
    {
        return [
            'total' => 'int8',
            'trigger' => 'float',
        ];
    }

    public function getMinimumLength() : int
    {
        return 15;
    }
}
