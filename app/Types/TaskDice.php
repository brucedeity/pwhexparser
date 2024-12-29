<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class TaskDice extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'quest_id' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 8;
    }
}
