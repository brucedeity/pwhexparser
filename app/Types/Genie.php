<?php

namespace App\Types;


use App\Contracts\Translatable;

class Genie extends Translatable
{
    public function getStructure(): array
    {
        return [
            'current_exp' => 'int8',
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
            'vigour' => 'int8',
            'status_value' => 'int8',
            'equipments_count' => 'int8',
            'skills_count' => 'skills_count',
            // 'skills' => 'skills', TODO
        ];
    }

    public function getMinimumLength() : int
    {
        return 83;
    }
}
