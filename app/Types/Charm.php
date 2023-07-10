<?php

namespace App\Types;

use App\Interfaces\Item;

class Charm implements Item
{
    public function getStructure(): array
    {
        return [
            'total' => 'lint',
            'trigger' => 'float',
        ];
    }

    public function getMinimumLength() : int
    {
        return 15;
    }
}
