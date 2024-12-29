<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class PetFood extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'honor' => 'int64',
            'food_mask' => 'int64',
        ];
    }

    public function getMinimumLength() : int
    {
        return 16;
    }
}
