<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class Property extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'vitality' => 'INT64_SIZE',
            'magic' => 'INT64_SIZE',
            'strength' => 'INT64_SIZE',
            'dexterity' => 'INT64_SIZE',
            'max_hp' => 'INT64_SIZE',
            'max_mp' => 'INT64_SIZE',
            'hp_regen' => 'INT64_SIZE',
            'mp_regen' => 'INT64_SIZE',
            'walk_speed' => 'float',
            'run_speed' => 'float',
            'swim_speed' => 'float',
            'fly_speed' => 'float',
            'acuracy' => 'INT64_SIZE',
            'min_physical_damage' => 'INT64_SIZE',
            'max_physical_damage' => 'INT64_SIZE',
            'attack_rate' => 'attack_rate',
            'attack_range' => 'float',
            'min_metal_damage' => 'INT64_SIZE',
            'max_metal_damage' => 'INT64_SIZE',
            'min_wood_damage' => 'INT64_SIZE',
            'max_wood_damage' => 'INT64_SIZE',
            'min_water_damage' => 'INT64_SIZE',
            'max_water_damage' => 'INT64_SIZE',
            'min_fire_damage' => 'INT64_SIZE',
            'max_fire_damage' => 'INT64_SIZE',
            'min_extra_damage' => 'INT64_SIZE',
            'max_extra_damage' => 'INT64_SIZE',
            'min_magic_damage' => 'INT64_SIZE',
            'max_magic_damage' => 'INT64_SIZE',
            'metal_resistance' => 'INT64_SIZE',
            'wood_resistance' => 'INT64_SIZE',
            'water_resistance' => 'INT64_SIZE',
            'fire_resistance' => 'INT64_SIZE',
            'resistance' => 'INT64_SIZE',
            'physical_resistance' => 'INT64_SIZE',
            'inclination' => 'INT64_SIZE',
            'chi' => 'INT64_SIZE',
        ];
    }

    public function getMinimumLength() : int32
    {
        return 290;
    }
}
