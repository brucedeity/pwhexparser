<?php

namespace App\Types;

use App\Interfaces\Item;

class SoulStone implements Item
{
    public function getStructure(): array
    {
        return [
            'w_addons_count' => 'addons_count',
            'addons' => 'addons',
            // 'level_requirement' => 'lint',
            // 'level_requirement1' => 'int',
            // 'a_addons_count' => 'addons_count',
            // 'level_requirement2' => 'int',
            // 'level_requirement3' => 'int',
            // 'level_requirement4' => 'int',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
