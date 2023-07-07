<?php

namespace App\Types;

use App\Interfaces\Item;

class Armor implements Item
{
    public function getStructure() : array
    {
        return [
            'name' => 'string',
            'defense' => 'int',
            'durability' => 'int',
            'weight' => 'int',
            'type' => 'string',
            'price' => 'int',
            'description' => 'string',
            'image' => 'string',
        ];
    }
}