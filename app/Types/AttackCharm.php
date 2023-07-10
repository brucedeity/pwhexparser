<?php

namespace App\Types;

use App\Interfaces\Item;

class AttackCharm implements Item
{
    public function getStructure(): array
    {
        return [
            'rune_type' => 'int',
            'min_weapon_level' => 'int',
            'max_weapon_level' => 'int',
            'damage_increase' => 'int',
        ];
    }

    public function getMinimumLength() : int
    {
        return 15;
    }
}
