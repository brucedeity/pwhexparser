<?php

namespace App\Types;

use App\Contracts\Item;

class Property implements Item
{
    public function getStructure(): array
    {
        return [
            'vitality' => 'int8',
            'magic' => 'int8',
            'strength' => 'int8',
            'dexterity' => 'int8',
            'max_hp' => 'int8',
            'max_mp' => 'int8',
            'hp_regen' => 'int8',
            'mp_regen' => 'int8',
            'walk_speed' => 'float',
            'run_speed' => 'float',
            'swim_speed' => 'float',
            'fly_speed' => 'float',
            'acuracy' => 'int8',
            'min_physical_damage' => 'int8',
            'max_physical_damage' => 'int8',
            'attack_rate' => 'attack_rate',
            'attack_range' => 'float',
            'min_metal_damage' => 'int8',
            'max_metal_damage' => 'int8',
            'min_wood_damage' => 'int8',
            'max_wood_damage' => 'int8',
            'min_water_damage' => 'int8',
            'max_water_damage' => 'int8',
            'min_fire_damage' => 'int8',
            'max_fire_damage' => 'int8',
            'min_extra_damage' => 'int8',
            'max_extra_damage' => 'int8',
            'min_magic_damage' => 'int8',
            'max_magic_damage' => 'int8',
            'metal_resistance' => 'int8',
            'wood_resistance' => 'int8',
            'water_resistance' => 'int8',
            'fire_resistance' => 'int8',
            'resistance' => 'int8',
            'physical_resistance' => 'int8',
            'inclination' => 'int8',
            'chi' => 'int8',
        ];
    }

    public function getMinimumLength() : int
    {
        return 290;
    }
}
