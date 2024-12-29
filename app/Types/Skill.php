<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Skill extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'skill' => 'INT64_SIZE',
            'level' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 8;
    }
}
