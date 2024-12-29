<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Weapon extends Translate implements Item
{
    public function getStructure() : array
    {
        return [
            'level' => 'int32',
            'class' => 'int32',
            'strength' => 'int32',
            'vitality' => 'int32',
            'dexterity' => 'int32',
            'magic' => 'int32',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'item_type' => 'int32',
            'item_flag' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'ranged_type' => 'INT64_SIZE',
            'weapon_type' => 'INT64_SIZE',
            'weapon_grade' => 'INT64_SIZE',
            'ammunition_type' => 'INT64_SIZE',
            'min_physical_damage' => 'INT64_SIZE',
            'max_physical_damage' => 'INT64_SIZE',
            'min_magic_damage' => 'INT64_SIZE',
            'max_magic_damage' => 'INT64_SIZE',
            'attack_rate' => 'attack_rate',
            'attack_range' => 'float',
            'minimum_range' => 'float',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 151;
    }
}
