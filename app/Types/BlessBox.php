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
            'physical_defense' => 'INT64_SIZE',
            'evasion' => 'INT64_SIZE',
            'mp' => 'INT64_SIZE',
            'hp' => 'INT64_SIZE',
            'metal_resistance' => 'INT64_SIZE',
            'wood_resistance' => 'INT64_SIZE',
            'water_resistance' => 'INT64_SIZE',
            'fire_resistance' => 'INT64_SIZE',
            'earth_resistance' => 'INT64_SIZE',
            'sockets_count' => 'sockets_count',
            'sockets' => 'sockets',
            'addons_count' => 'addons_count',
            'addons' => 'addons',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 135;
    }
}
