<?php

namespace App;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Types\Weapon;
use App\Types\Armor;

const INT_SIZE = 4;
const LINT_SIZE = 8;
const SHORT_SIZE = 2;
const ATTACK_RATE_FACTOR = 20;
const CHAR_SIZE_IN_HEX = 4;

class Decoder
{
    private $position = 0;
    private $octetString = '';
    private $parsedOctet = '';
    private $namePos = 48;
    private $nameLength = 0;
    private $socketsCount = 0;

    public function __construct()
    {
        $this->octetString = '1b00ff005300000012000000e81c0000e81c00002c00030e4400720061006b00610065007200010000000d00000004000000622100007d000000220100002c010000c2010000040000000000a0410000a04003000000350e0000350e000000000000050000009c25000011000000c14100002d03000001000000b346000032000000050000002ca200000c0000002ca200000c000000';
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
            // $result[$field] = $this->unmarshal($field, $type);

            // continue;

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
            case 'sockets_count':
                return $this->getSocketsCount($field);

            case 'sockets':
                return $this->getSockets();

            case 'name':
                return $this->getName();

            case 'attack_rate':
                return $this->getAttackRate($field);

            case 'name_length':
                return $this->getNameLength($field);

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

                $this->position += SHORT_SIZE;
                return $value;

            case 'float':
                $octet = substr($this->octetString, $this->position, LINT_SIZE);
                
                $this->parsedOctet = $octet;
                $this->position += LINT_SIZE;
                return $this->toFloat($octet);
        }
    }

    public function getName() : string
    {
        $name = '';
    
        for ($i=0; $i < $this->nameLength; $i++) { 
            $name .= chr($this->toDecimal(substr($this->octetString, $this->position + ($i * INT_SIZE), 2), 2, 0, true));
        }
    
        $this->position += $this->nameLength * CHAR_SIZE_IN_HEX;
    
        return $name;
    }

    public function getSocketsCount(string $field) : int
    {
        $this->socketsCount = $this->unmarshal($field, 'lint');
    
        return $this->socketsCount;
    }

    public function getSockets()
    {
        $sockets = [];

        if ($this->socketsCount <= 0)
            return $sockets;


        for ($i=1; $i < $this->socketsCount; $i++) { 

            $octet = $this->position + ($i * LINT_SIZE);
            $octet = substr($this->octetString, $octet, LINT_SIZE);

            $sockets[$i] = $this->unmarshal($octet, 'lint');
        }

        return $sockets;
    }

    public function getAttackRate(string $field) : float
    {
        $attackRate = ATTACK_RATE_FACTOR / $this->unmarshal($field, 'lint');
    
        return round($attackRate, 2);
    }

    public function getNameLength(string $field) : int
    {
        $nameLength = $this->unmarshal($field, 'short') / 2;

        $this->nameLength = $nameLength;

        return $nameLength;
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
            $hex = $this->reverseNumber($str);
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

    public function toFloat(string $octet) : float
    {
        $float_value = unpack("f", pack("H*", $octet))[1];
        return $float_value;
    }

    public function toDecimal(string $hexString, int $expectedLength, int $prefixToRemove = 0, bool $reverse = true)
    {
        $paddingLength = $expectedLength - strlen($hexString);
        
        $hexString = str_pad($hexString, $paddingLength, '0', STR_PAD_LEFT);
    
        if ($reverse) {
            $hexString = $this->reverseNumber($hexString);
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