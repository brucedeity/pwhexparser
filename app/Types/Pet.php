<?php

namespace App\Types;

use App\Interfaces\Item;

class Pet implements Item
{
    public function getStructure(): array
    {
        return [
            'level_requirement' => 'lint',
            'required_class' => 'lint',
            'loyalty' => 'lint',
            'pet_id' => 'lint',
            'pet_vis_tid' => 'lint',
            'egg_id' => 'lint',
            'pet_type' => 'lint',
            'pet_level' => 'int',
            'color' => 'int',
            'current_exp' => 'lint',
            'skill_points' => 'lint',
            'name_length' => 'name_length',
            'name' => 'pack_name',
            'skills_count' => 'skills_count',
            'skills' => 'pet_skills',
        ];
    }

    public function getMinimumLength() : int
    {
        return 119;
    }
}