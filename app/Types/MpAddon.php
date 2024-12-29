<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class MpAddon extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'total' => 'INT64_SIZE',
            'trigger' => 'float',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 15;
    }
}
