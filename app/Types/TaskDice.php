<?php

namespace App\Types;

use App\Contracts\Item;

class TaskDice implements Item
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
