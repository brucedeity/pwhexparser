<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class AttackCharm extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'rune_type' => 'int32',
            'min_weapon_level' => 'int32',
            'max_weapon_level' => 'int32',
            'damage_increase' => 'int32',
        ];
    }

    public function getMinimumLength() : int
    {
        return 15;
    }
}
