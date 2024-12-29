<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class StallCard extends Translate implements Item
{
    public function getStructure(): array
    {
        return [];
    }

    public function getMinimumLength() : int
    {
        return 0;
    }
}
