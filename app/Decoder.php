<?php

namespace App;

use App\Types\Weapon;
use App\Types\Armor;

const INT_SIZE = 4;
const LINT_SIZE = 8;
const SHORT_SIZE = 2;

class Decoder
{
    private $position = 0;
    private $octetString = '';
    private $parsedOctet = '';
    private $namePos = 48;
    private $nameLength = 0;

    public function __construct()
    {
        $this->octetString = '5a00db003100000000000e011a100000ec2c00002c0004125300610063006500720064006f007400650000000000240100000b000000000000009b01000068020000ec0200009203000010000000000040400000000001000000e718000004000000b921000003000000ca2500000e000000cf2500000e00000084a4000019000000';
    }

    public function getOctetString() : string
    {
        return $this->octetString;
    }

    public function decodeOctets(string $octets = '') : array
    {
        $typeClass = $this->getTypeClass('Weapon');

        $result = [];

        foreach ($typeClass->getStructure() as $field => $type) {
            $result[$field] = $this->unmarshal($field, $type);

            continue;

            $result[$field] = [
                'pos' => $this->position,
                'value' => $this->unmarshal($field, $type),
                'octet' => $this->parsedOctet,
             
            ];

            continue;

        }

        return $result;
    }

    public function unmarshal(string $field, string $type)
    {
        switch ($type)
        {
            case 'sockets':
                $octet = substr($this->octetString, $this->position, 32);
                $this->parsedOctet = $octet;
                $this->position += 32;
                return $this->toDecimal($octet, 4, 0, true);

            case 'name':
                return $this->getName();

            case 'int':
                $octet = substr($this->octetString, $this->position, INT_SIZE);
                $this->parsedOctet = $octet;
                $this->position += INT_SIZE;
                return $this->toDecimal($octet, INT_SIZE, 0, true);

            case 'lint':
                $octet = substr($this->octetString, $this->position, LINT_SIZE);
                $this->parsedOctet = $octet;
                $this->position += LINT_SIZE;
                return $this->toDecimal($octet, LINT_SIZE, 0, true);

            case 'short':
                $octet = substr($this->octetString, $this->position, SHORT_SIZE);
                $this->parsedOctet = $octet;
                $value = $this->toDecimal($octet, SHORT_SIZE, 0, true);

                if ($field == 'name_length') {
                    $this->nameLength = $value;
                }

                $this->position += SHORT_SIZE;
                return $value;
        }
    }

    public function getName() : string
    {
        $name = '';

        for ($i=0; $i < $this->nameLength; $i++) { 
            $char = substr($this->octetString, $this->position + ($i * INT_SIZE), INT_SIZE);
            $char = substr($char, 0, 2);
            $char = $this->toDecimal($char, 2, 0, true);
            $name .= chr($char);

            // $this->position += $i * 4 + 4;
            // continue;
        }

        $this->position += $this->nameLength * 2;

        return $name;
    }

    public function getTypeClass(string $type) : object
    {
        if (!in_array($type, ['Weapon', 'Armor']))
            throw new \Exception('Invalid type');

        $class = 'App\Types\\' . $type;

        return new $class;
    }

    public function reverseNumber($number)
    {
        if (strlen($number) <= 1)
            return $number;

        return $this->reverseNumber(substr($number, 2)) . substr($number, 0, 2);
    }

    public function hextoDec(string $str, int $flen, int $adds, bool $rev): int
    {
        $diff = $flen - strlen($str);
        for ($i=0; $i<$diff; $i++) {
            $str = '0'.$str;
        }   
        if ($rev !== false){
            $hex = $this->ReverseNumber($str);
        } else {
            $hex = $str;
        }
        if (!ctype_xdigit($hex)){
            $hex = 0;
        }
        $hex = ltrim($hex, '0');
        if (empty($hex)){
            $hex = 0;
        }
        if ($adds != 0){
            if (substr($hex, 0, 1) == $adds){
                $hex = substr($hex, 1);
            } else {
                $hex = 0;
            }
        }
        return hexdec($hex);
    }

    public function toDecimal(string $hexString, int $expectedLength, int $prefixToRemove = 0, bool $reverse = true)
    {
        $paddingLength = $expectedLength - strlen($hexString);
        
        $hexString = str_pad($hexString, $paddingLength, '0', STR_PAD_LEFT);
    
        if ($reverse) {
            $hexString = $this->ReverseNumber($hexString);
        }
    
        if (!ctype_xdigit($hexString)) {
            return 0;
        }
    
        if (empty($hexString)) {
            return 0;
        }
    
        if ($prefixToRemove !== 0) {
            if (strpos($hexString, $prefixToRemove) === 0) {
                $hexString = substr($hexString, 1);
            }
        }

        return base_convert($hexString, 16, 10);
    }
}