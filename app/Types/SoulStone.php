<?php

namespace App\Types;

use App\Contracts\Item;
use App\Contracts\Translate;

class SoulStone extends Translate implements Item
{
    public function getStructure(): array
    {
        return [
            'w_addons_count' => 'addons_count',
            'addons' => 'addons',
            // 'level' => 'int64',
            // 'level1' => 'int32',
            // 'a_addons_count' => 'addons_count',
            // 'level2' => 'int32',
            // 'level3' => 'int32',
            // 'level4' => 'int32',
        ];
    }

    public function getMinimumLength() : int
    {
        return 32;
    }
}
