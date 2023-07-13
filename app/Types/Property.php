<?php

namespace App\Types;

use App\Interfaces\Item;

class Property implements Item
{
    public function getStructure(): array
    {
        return [
            'vitality' => 'lint',
            'magic' => 'lint',
            'strength' => 'lint',
            'dexterity' => 'lint',
            'max_hp' => 'lint',
            'max_mp' => 'lint',
            'hp_regen' => 'lint',
            'mp_regen' => 'lint',
            'walk_speed' => 'float',
            'run_speed' => 'float',
            'swim_speed' => 'float',
            'fly_speed' => 'float',
            'acuracy' => 'lint',
            'min_physical_damage' => 'lint',
            'max_physical_damage' => 'lint',
            'attack_rate' => 'attack_rate',
            'attack_range' => 'float',
            'min_metal_damage' => 'lint',
            'max_metal_damage' => 'lint',
            'min_wood_damage' => 'lint',
            'max_wood_damage' => 'lint',
            'min_water_damage' => 'lint',
            'max_water_damage' => 'lint',
            'min_fire_damage' => 'lint',
            'max_fire_damage' => 'lint',
            'min_extra_damage' => 'lint',
            'max_extra_damage' => 'lint',
            'min_magic_damage' => 'lint',
            'max_magic_damage' => 'lint',
            'metal_resistance' => 'lint',
            'wood_resistance' => 'lint',
            'water_resistance' => 'lint',
            'fire_resistance' => 'lint',
            'resistance' => 'lint',
            'physical_resistance' => 'lint',
            'inclination' => 'lint',
            'chi' => 'lint',
        ];
    }

    public function getMinimumLength() : int
    {
        return 290;
    }
}
