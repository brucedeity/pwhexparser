<?php

namespace App\Types;


use App\Contracts\Translatable;

class SoulStone extends Translatable
{
    public function getStructure(): array
    {
        return [
            'w_addons_count' => 'addons_count',
            'addons' => 'addons',
            // 'level' => 'int8',
            // 'level1' => 'int',
            // 'a_addons_count' => 'addons_count',
            // 'level2' => 'int',
            // 'level3' => 'int',
            // 'level4' => 'int',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
