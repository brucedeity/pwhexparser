<?php

namespace App\Types;

use App\Types\Unequippable;

class Bible extends Unequippable
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
