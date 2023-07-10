<?php

namespace App\Types;

use App\Interfaces\Item;

class Ammo implements Item
{
    public function getStructure(): array
    {
        return [
            'level_requirement' => 'int',
            'required_class' => 'int',
            'strength_requirement' => 'int',
            'constitution_requirement' => 'int',
            'agility_requirement' => 'int',
            'intelligence_requirement' => 'int',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'unknown1' => 'lint',
            'type' => 'lint',
            'damage' => 'lint',
            'damage_scale' => 'lint',
            'min_weapon_grade' => 'lint',
            'max_weapon_grade' => 'lint',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int
    {
        return 103;
    }
}
