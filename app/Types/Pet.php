<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Pet extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'INT64_SIZE',
            'required_class' => 'INT64_SIZE',
            'loyalty' => 'INT64_SIZE',
            'pet_id' => 'INT64_SIZE',
            'pet_vis_tid' => 'INT64_SIZE',
            'egg_id' => 'INT64_SIZE',
            'pet_type' => 'INT64_SIZE',
            'pet_level' => 'int32',
            'color' => 'int32',
            'current_exp' => 'INT64_SIZE',
            'skill_points' => 'INT64_SIZE',
            'name_length' => 'name_length',
            'name' => 'pack_name',
            'skills_count' => 'skills_count',
            'skills' => 'skills',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 119;
    }
}
