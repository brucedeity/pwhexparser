<?php

namespace App;

use App\Types\Weapon;
use App\Types\Armor;

class Decoder
{
    public function decodeOctets(string $octets = '') : array
    {
        $typeClass = $this->getTypeClass('Weapon');

        $octets = '1b00ff005300000012000000e81c0000e81c00002c000300000000000900000004000000000
        000007d0000002201000000000000000000001800000000006040000000000000000000000
        000';

        $result = [];

        foreach ($typeClass->getStructure() as $key => $type) {
            $method = 'get' . ucfirst($type);
            $value = $this->$method($octets);
            $octets = substr($octets, strlen($value));
            $result[$key] = $value;
        }

        return $result;
    }

    public function getTypeClass(string $type) : string
    {
        return 'App\Types\\' . $type;
    }

    public function reverseNumber($number)
    {
        if (strlen($number) <= 1)
            return $number;

        return $this->reverseNumber(substr($number, 2)) . substr($number, 0, 2);
    }
}