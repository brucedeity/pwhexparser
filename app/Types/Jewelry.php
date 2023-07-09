<?php

namespace App\Types;

use App\Interfaces\Item;

class Jewelry implements Item
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
            'min_durability' => 'lint',
            'max_durability' => 'lint',
            'item_type' => 'int',
            'item_flag' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'physical_attack' => 'lint',
            'magic_attack' => 'lint',
            'physical_defense' => 'lint',
            'dodge' => 'lint',
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
