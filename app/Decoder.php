<?php

namespace App;

use App\Interfaces\Item;

const INT_SIZE = 4;
const LINT_SIZE = 8;
const SHORT_SIZE = 2;
const ATTACK_RATE_FACTOR = 20;
const SUPER_INT_SIZE = 16;

class Decoder
{
    private $position = 0;
    private $hexString = '';
    private $parsedOctet = ''; // Will be deleted
    private $nameLength = 0;
    private $socketsCount = 0;
    private $addonsCount = 0;
    private $skillsCount = 0;
    private $itemType;

    public function sethexString(string $hexString): void
    {
        $this->hexString = $hexString;
    }

    public function gethexString(): string
    {
        return $this->hexString;
    }

    public function setItemType(string $itemType): void
    {
        if (!in_array($itemType, ['Weapon', 'Armor', 'Jewelry', 'Pet', 'Fashion', 'Card', 'Flight', 'BlessBox'])) {
            throw new \Exception('Error when trying to set an invalid item type: ' . $itemType);
        }

        $itemTypeObject = 'App\Types\\' . $itemType;

        $this->itemType = new $itemTypeObject();
    }

    public function getItemType(): Item
    {
        return $this->itemType;
    }

    public function validateHex(): bool
    {
        if (empty($this->getHexString())) {
            throw new \Exception('Hex string not set, please use setHexString() method before calling validateHex()');
        }

        if ($this->getItemType() === null) {
            throw new \Exception('Item type not set, please use setItemType() method before calling decodeHexString()');
        }

        if (strlen($this->getHexString()) < $this->getItemType()->getMinimumLength()) {
            throw new \Exception('Hex string is too short for ' . get_class($this->itemType) . ', given: ' . strlen($this->getHexString()) . ', expected: ' . $this->getItemType()->getMinimumLength() . '');
        }

        return true;
    }

    public function decodeHexString(): array
    {
        $result = [];

        foreach ($this->getItemType()->getStructure() as $field => $type) {
            $result[$field] = $this->decodeType($field, $type);
        }

        return $result;
    }

    public function debugHexString(): array
    {
        $result = [];

        foreach ($this->getItemType()->getStructure() as $field => $type) {
            $result[$field] = [
                'pos' => $this->position,
                'value' => $this->decodeType($field, $type),
                'octet' => $this->parsedOctet,
            ];
        }

        return $result;
    }

    public function decodeType(string $field, string $type, int $prefixToRemove = 0)
    {
        switch ($type) {
            case 'addons_count':
                return $this->getAddonsCount($field);

            case 'addons':
                return $this->getAddons();

            case 'sockets_count':
                return $this->getSocketsCount($field);

            case 'sockets':
                return $this->getSockets();

            case 'name':
                return $this->getName();

            case 'pack_name':
                return $this->packName();

            case 'pet_skills':
                return $this->getPetSkills($field);

            case 'skills_count':
                return $this->getSkillsCount($field);

            case 'attack_rate':
                return $this->getAttackRate($field);

            case 'name_length':
                return $this->getNameLength($field);

            case 'durability':
                return $this->getDurability($field);

            case 'int':
                $hex = substr($this->getHexString(), $this->position, INT_SIZE);
                $this->parsedOctet = $hex;
                $this->position += INT_SIZE;
                return $this->hexToDecimal($hex, INT_SIZE, $prefixToRemove, true);

            case 'lint':
                $hex = substr($this->getHexString(), $this->position, LINT_SIZE);
                $this->parsedOctet = $hex;
                $this->position += LINT_SIZE;
                return $this->hexToDecimal($hex, LINT_SIZE, $prefixToRemove, true);

            case 'short':
                $hex = substr($this->getHexString(), $this->position, SHORT_SIZE);
                $this->parsedOctet = $hex;
                $value = $this->hexToDecimal($hex, SHORT_SIZE, $prefixToRemove, true);

                $this->position += SHORT_SIZE;
                return $value;

            case 'float':
                $hex = substr($this->getHexString(), $this->position, LINT_SIZE);

                $this->parsedOctet = $hex;
                $this->position += LINT_SIZE;
                return $this->toFloat($hex);
        }
    }

    public function getSkillsCount(string $field) : int
    {
        $this->skillsCount = $this->decodeType($field, 'int');

        $this->position += SUPER_INT_SIZE;

        return $this->skillsCount;
    }

    public function getPetSkills(string $field) : array
    {
        $skills = [];

        for ($i = 0; $i < $this->skillsCount; $i++) {

            $skillPos = $this->position + SUPER_INT_SIZE + ($i * SUPER_INT_SIZE);

            $skill = [
                'id' => $this->hexToDecimal(substr($this->getHexString(), $skillPos, LINT_SIZE), LINT_SIZE, 0, true),
                'level' => $this->hexToDecimal(substr($this->getHexString(), $skillPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
            ];

            array_push($skills, $skill);
        }

        return $skills;
    }

    public function getName(): string
    {
        $name = '';

        $nameLength = $this->nameLength / 2;

        for ($i = 0; $i < $nameLength; $i++) {
            $name .= chr($this->hexToDecimal(substr($this->getHexString(), $this->position + $i * INT_SIZE, 2), 2, 0, true));
        }

        $this->position += $nameLength * INT_SIZE;

        return $name;
    }

    public function packName() : string
    {
        $name = '';

        $initialPos = $this->position + INT_SIZE;
        
        for ($i = 0; $i < $this->nameLength; $i++) {
            $parsedOctet = substr($this->getHexString(), $initialPos + $i * INT_SIZE + SHORT_SIZE, SHORT_SIZE);
            
            $name .= pack("H*", $parsedOctet);
        }

        $this->position += SHORT_SIZE;

        return $name;
    }

    public function getAddonsCount(string $field): int
    {
        $this->addonsCount = $this->decodeType($field, 'lint');

        if ($this->addonsCount > 30)
            throw new \Exception('Invalid addons count, max value is 30, got ' . $this->addonsCount . ' instead');

        return $this->addonsCount;
    }

    public function getAddons()
    {
        $addons = [
            'special_addons' => [],
            'normal_addons' => [],
            'refine' => [],
            'socket' => [],
        ];

        if ($this->addonsCount <= 0) {
            return $addons;
        }

        $socketIndex = 0;
        $shift = 0;

        for ($i = 0; $i < $this->addonsCount; $i++) {
            $addonPos = $this->position + $i * SUPER_INT_SIZE + $shift;
            $hex = substr($this->getHexString(), $addonPos, LINT_SIZE);
            $hex = ltrim($this->reverseHexNumber($hex), '0');

            if (strlen($hex) % 2 != 0) {
                continue;
            }

            $hex = trim($hex);
            $addonType = substr($hex, 0, 1);

            if ($addonType == "4") {
                $addonId = $this->hexToDecimal($hex, LINT_SIZE, $addonType, false);

                if ($addonId > 1691 && $addonId < 1892) {
                    $addons['refine'] = [
                        'id' => $addonId,
                        'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                        'level' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + SUPER_INT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                    ];
                } else {
                    $addon = [
                        'id' => $addonId,
                        'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                        'level' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + SUPER_INT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                    ];

                    array_push($addons['special_addons'], $addon);
                }

                $shift += LINT_SIZE;
            } elseif ($addonType == 'a') {
                $socketIndex++;
                $addonId = $this->hexToDecimal($hex, LINT_SIZE, $addonType, false);
                $socketAddon = [
                    'index' => $socketIndex,
                    'id' => $addonId,
                    'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                ];

                array_push($addons['socket'], $socketAddon);
            } else {
                $addonId = hexdec(substr($hex, 1));

                $addon = [
                    'id' => $addonId,
                    'value' => intval($this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true), 10),
                ];

                array_push($addons['normal_addons'], $addon);
            }
        }

        return $addons;
    }

    public function getSocketsCount(string $field): int
    {
        $this->socketsCount = $this->decodeType($field, 'int');
        $this->position += INT_SIZE;

        return $this->socketsCount;
    }

    public function getSockets()
    {
        $sockets = [];

        if ($this->socketsCount <= 0) {
            return $sockets;
        } elseif ($this->socketsCount > 4) {
            throw new \Exception('Invalid sockets count, max value is 4, got ' . $this->socketsCount . ' instead');
        }

        for ($i = 0; $i < $this->socketsCount; $i++) {
            $hex = $this->position + $i * LINT_SIZE;
            $hex = substr($this->getHexString(), $hex, LINT_SIZE);

            $sockets[$i] = $this->decodeType($hex, 'lint');
        }

        return $sockets;
    }

    public function getAttackRate(string $field): float
    {
        $attackRate = $this->decodeType($field, 'lint');

        if ($attackRate <= 0) return 0;

        $attackRate = ATTACK_RATE_FACTOR / $attackRate;

        return round($attackRate, 2);
    }

    public function getNameLength(string $field): int
    {
        $nameLength = $this->decodeType($field, 'short');
        $this->nameLength = $nameLength;

        return $nameLength;
    }

    public function getDurability(string $field): int
    {
        $durability = $this->decodeType($field, 'lint');

        return $durability / 100;
    }

    public function reverseHexNumber($number)
    {
        return implode('', array_reverse(str_split($number, 2)));
    }

    public function toFloat(string $hex): float
    {
        $float_value = unpack("f", pack("H*", $hex))[1];
        return $float_value;
    }

    public function hexToDecimal(string $hexString, int $expectedLength, mixed $prefixToRemove = 0, bool $reverse = true)
    {
        $paddingLength = $expectedLength - strlen($hexString);

        $hexString = str_pad($hexString, $paddingLength, '0', STR_PAD_LEFT);

        if ($reverse) {
            $hexString = $this->reverseHexNumber($hexString);
        }

        if (empty($hexString) || !ctype_xdigit($hexString)) {
            return 0;
        }

        if ($prefixToRemove !== 0 && strpos($hexString, $prefixToRemove) === 0) {
            $hexString = substr($hexString, 1);
        }

        return intval(base_convert($hexString, 16, 10));
    }
}
