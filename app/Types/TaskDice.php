<?php

namespace App\Types;

use App\Interfaces\Item;

class TaskDice implements Item
{
    public function getStructure(): array
    {
        return [
            'quest_id' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 8;
    }
}
