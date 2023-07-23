<?php

namespace App\Types;

use App\Interfaces\Item;

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
