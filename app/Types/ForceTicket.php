<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class ForceTicket extends Translate implements Item
{
    public function getStructure(): array
    {
        return [];
    }

    public function getMinimumLength() : int32
    {
        return 0;
    }
}
