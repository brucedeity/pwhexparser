<?php

namespace App\Interfaces;

interface Item
{
    public function getStructure() : array;
    public function getMinimumLength() : int;
}