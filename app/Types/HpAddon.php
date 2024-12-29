<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class HpAddon extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'total' => 'int64',
            'trigger' => 'float',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 15;
    }
}
