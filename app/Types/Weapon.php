<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Weapon extends Translate implements Item
{
    public function getStructure() : array
    {
        return [
            'level' => 'int',
            'class' => 'int',
            'strength' => 'int',
            'vitality' => 'int',
            'dexterity' => 'int',
            'magic' => 'int',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'item_type' => 'int',
            'item_flag' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'ranged_type' => 'int8',
            'weapon_type' => 'int8',
            'weapon_grade' => 'int8',
            'ammunition_type' => 'int8',
            'min_physical_damage' => 'int8',
            'max_physical_damage' => 'int8',
            'min_magic_damage' => 'int8',
            'max_magic_damage' => 'int8',
            'attack_rate' => 'attack_rate',
            'attack_range' => 'float',
            'minimum_range' => 'float',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int
    {
        return 151;
    }
}
