<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class TaskDice extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'quest_id' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 8;
    }
}
