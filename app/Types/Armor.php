<?php

namespace App\Types;

use App\Interfaces\Item;

class Armor implements Item
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
            'physical_defense' => 'lint',
            'evasion' => 'lint',
            'mp' => 'lint',
            'hp' => 'lint',
            'metal_resistance' => 'lint',
            'wood_resistance' => 'lint',
            'water_resistance' => 'lint',
            'fire_resistance' => 'lint',
            'earth_resistance' => 'lint',
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
