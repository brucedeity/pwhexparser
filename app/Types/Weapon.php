<?php

namespace App\Types;

use App\Interfaces\Item;

class Weapon implements Item
{
    public function getStructure() : array
    {
        return [
            'level' => 'int',
            'strength' => 'int',
            'vitality' => 'int',
            'dexterity' => 'int',
            'durability' => 'int',
            'max_durability' => 'int',
            'min_physical_damage' => 'int',
            'max_physical_damage' => 'int',
            'min_magic_damage' => 'int',
            'max_magic_damage' => 'int',
            'attack_rate' => 'float',
            'attack_range' => 'int',
        ];
    }
}