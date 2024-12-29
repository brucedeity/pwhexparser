<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Skill extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'skills' => [
                'skill' => 'int64',
                'progress' => 'int64',
                'level' => 'int64',
            ]
        ];
    }

    public function getMinimumLength() : int
    {
        return 8;
    }
}
