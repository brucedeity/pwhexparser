<?php

namespace App\Types;


use App\Contracts\Translatable;

class Bugle extends Translatable
{
    public function getStructure(): array
    {
        return [];
    }

    public function getMinimumLength() : int
    {
        return 0;
    }
}
