<?php

namespace App\Types;

use App\Contracts\Item;

class BlessBox implements Item
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
            'physical_defense' => 'int8',
            'evasion' => 'int8',
            'mp' => 'int8',
            'hp' => 'int8',
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