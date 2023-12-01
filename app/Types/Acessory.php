<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Acessory extends Translate implements Item
{
    public function getStructure(): array
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
            'physical_attack' => 'int8',
            'magic_attack' => 'int8',
            'physical_defense' => 'int8',
            'dodge' => 'int8',
            'metal_resistance' => 'int8',
            'wood_resistance' => 'int8',
            'water_resistance' => 'int8',
            'fire_resistance' => 'int8',
            'earth_resistance' => 'int8',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int
    {
        return 135;
    }
}
