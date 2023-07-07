<?php

namespace App\Types;

use App\Interfaces\Item;

class Weapon implements Item
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
            'min_durability' => 'lint',
            'max_durability' => 'lint',
            'item_type' => 'int',
            'item_flag' => 'short',
            'name_length' => 'short',
            'name' => 'name',
            'ranged_type' => 'lint',
            'weapon_type' => 'lint',
            'weapon_grade' => 'lint',
            'ammunition_type' => 'lint',
            'min_physical_damage' => 'lint',
            'max_physical_damage' => 'lint',
            'min_magic_damage' => 'lint',
            'max_magic_damage' => 'lint',
            'attack_rate' => 'lint',
            'attack_range' => 'lint',
            'minimum_effective_range' => 'lint',
            'sockets_count' => 'lint',
            'sockets' => 'sockets',
            'addons_count' => 'lint',
            'addons' => 'addons',
        ];
    }
}