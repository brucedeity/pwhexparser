<?php

namespace App\Types;


use App\Contracts\Translatable;

class TaskDice extends Translatable
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
