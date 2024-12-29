<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Ammo extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'int32',
            'required_class' => 'int32',
            'strength_requirement' => 'int32',
            'constitution_requirement' => 'int32',
            'agility_requirement' => 'int32',
            'intelligence_requirement' => 'int32',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'unknown1' => 'INT64_SIZE',
            'type' => 'INT64_SIZE',
            'damage' => 'INT64_SIZE',
            'damage_scale' => 'INT64_SIZE',
            'min_weapon_grade' => 'INT64_SIZE',
            'max_weapon_grade' => 'INT64_SIZE',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 103;
    }
}
