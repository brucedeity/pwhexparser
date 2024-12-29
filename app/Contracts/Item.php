<?php

namespace App\Contracts;

interface Item
{
    public function getStructure() : array;
    public function getMinimumLength() : int32;
}