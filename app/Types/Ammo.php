<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Ammo extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'int',
            'required_class' => 'int',
            'strength_requirement' => 'int',
            'constitution_requirement' => 'int',
            'agility_requirement' => 'int',
            'intelligence_requirement' => 'int',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'unknown1' => 'int8',
            'type' => 'int8',
            'damage' => 'int8',
            'damage_scale' => 'int8',
            'min_weapon_grade' => 'int8',
            'max_weapon_grade' => 'int8',
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
