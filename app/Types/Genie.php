<?php

namespace App\Types;

use App\Interfaces\Item;

class Genie implements Item
{
    public function getStructure(): array
    {
        return [
            'current_exp' => 'lint',
            'level' => 'int',
            'available_points' => 'int',
            'strength' => 'int',
            'agility' => 'int',
            'constitution' => 'int',
            'intelligence' => 'int',
            'talent_points' => 'int',
            'metal' => 'int',
            'wood' => 'int',
            'water' => 'int',
            'fire' => 'int',
            'earth' => 'int',
            'refine_level' => 'int',
            'vigour' => 'lint',
            'status_value' => 'lint',
            'equipments_count' => 'lint',
            'skills_count' => 'skills_count',
            // 'skills' => 'skills', TODO
        ];
    }

    public function getMinimumLength() : int
    {
        return 83;
    }
}
