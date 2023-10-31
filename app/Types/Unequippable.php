<?php

namespace App\Types;

use App\Contracts\Item;

class Unequippable implements Item
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
