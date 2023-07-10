<?php

namespace App\Types;

use App\Interfaces\Item;

class PetFood implements Item
{
    public function getStructure(): array
    {
        return [
            'honor' => 'lint',
            'food_mask' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 16;
    }
}
