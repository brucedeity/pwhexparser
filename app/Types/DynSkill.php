<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class DynSkill extends Translate implements Item
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
