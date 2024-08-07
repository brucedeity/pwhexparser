<?php

namespace App\Types;

use App\Types\Unequippable;

class DynSkill extends Unequippable
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
