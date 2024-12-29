<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class BlessBox extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'level' => 'int32',
            'class' => 'int32',
            'strength' => 'int32',
            'vitality' => 'int32',
            'dexterity' => 'int32',
            'magic' => 'int32',
            'min_durability' => 'durability',
            'max_durability' => 'durability',
            'item_type' => 'int32',
            'item_flag' => 'short',
            'name_length' => 'name_length',
            'name' => 'name',
            'physical_defense' => 'int64',
            'evasion' => 'int64',
            'mp' => 'int64',
            'hp' => 'int64',
            'metal_resistance' => 'int64',
            'wood_resistance' => 'int64',
            'water_resistance' => 'int64',
            'fire_resistance' => 'int64',
            'earth_resistance' => 'int64',
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
