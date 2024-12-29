<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class PetFood extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'honor' => 'INT64_SIZE',
            'food_mask' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 16;
    }
}
