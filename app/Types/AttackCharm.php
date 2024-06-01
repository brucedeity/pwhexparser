<?php

namespace App\Types;

use App\Contracts\Translatable;

class AttackCharm extends Translatable
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
