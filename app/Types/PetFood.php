<?php

namespace App\Types;


use App\Contracts\Translatable;

class PetFood extends Translatable
{
    public function getStructure(): array
    {
        return [
            'honor' => 'int8',
            'food_mask' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 16;
    }
}
