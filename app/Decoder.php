<?php

namespace App;

require_once 'Constants.php';

use App\Interfaces\Item;

class Decoder
{
    private $position = 0;
    private $hexString = '';
    private $parsedHex = ''; // Will be deleted
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
        if (!in_array($itemType, AVAILABLE_TYPES)) {
            throw new \Exception('Error when trying to set an invalid item type: ' . $itemType);
        }

        $itemTypeObject = 'App\Types\\' . $itemType;

        $this->itemType = new $itemTypeObject();
    }

    public function guessItemType(int $mask) : void
    {
        $types = [
            0 => 'Unequippable',
            1 => 'Weapon',
            16 => 'Armor',
            64 => 'Armor',
            128 => 'Armor',
            256 => 'Armor',
            2 => 'Armor',
            8 => 'Armor',
            4 => 'Jewelry',
            32 => 'Fashion',
            1536 => 'Jewelry',
            262144 => 'Card',
            4096 => 'Flight',
            8192 => 'Fashion',
            16384 => 'Fashion',
            65536 => 'Fashion',
            32768 => 'Fashion',
            524288 => 'Fashion',
            131072 => 'AttackCharm',
            1048576 => 'Charm',
            2097152 => 'Charm',
            2048 => 'Ammo',
            1077936128 => 'BlessBox',
            8388608 => 'Pet',
            33554432 => 'Fashion',
            16777216 => 'Genie'
        ];

        if (!isset($types[$mask]))
            throw new \Exception('Unable to guess item type from mask: ' . $mask);

        $this->setItemType($types[$mask]);
    }

    public function getItemType(): Item
    {
        return $this->itemType;
    }

    private function validateHex(): void
    {
        if (empty($this->getHexString())) {
            throw new \Exception('Hex string not set, please use setHexString() method before calling validateHex()');
        }
        elseif (!ctype_xdigit($this->getHexString())) {
            throw new \Exception('Invalid hexadecimal string for type '. get_class($this->itemType));
        }
        elseif ($this->getItemType() === null) {
            throw new \Exception('Item type not set, please use setItemType() method before calling decodeHexString()');
        }
        elseif (strlen($this->getHexString()) < $this->getItemType()->getMinimumLength()) {
            throw new \Exception('Hex string is too short for ' . get_class($this->itemType) . ', given: ' . strlen($this->getHexString()) . ', expected: ' . $this->getItemType()->getMinimumLength() . '');
        }
    }    

    public function decodeHexString(): array
    {
        $this->validateHex();

        $result = [];

        foreach ($this->getItemType()->getStructure() as $field => $type) {
            $result[$field] = $this->decodeType($field, $type);
        }

        return $result;
    }

    public function debugHexString(): array
    {
        $this->validateHex();

        $result = [];

        foreach ($this->getItemType()->getStructure() as $field => $type) {
            $result[$field] = [
                'pos' => $this->position,
                'value' => $this->decodeType($field, $type),
                'hex' => $this->parsedHex,
            ];
        }

        return $result;
    }

    private function decodeType(string $field, string $type, int $prefixToRemove = 0)
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

            case 'skills':
                return $this->getSkills($field);

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
                $this->parsedHex = $hex;
                $this->position += INT_SIZE;
                return $this->hexToDecimal($hex, INT_SIZE, $prefixToRemove, true);

            case 'lint':
                $hex = substr($this->getHexString(), $this->position, LINT_SIZE);
                $this->parsedHex = $hex;
                $this->position += LINT_SIZE;
                return $this->hexToDecimal($hex, LINT_SIZE, $prefixToRemove, true);

            case 'short':
                $hex = substr($this->getHexString(), $this->position, SHORT_SIZE);
                $this->parsedHex = $hex;
                $value = $this->hexToDecimal($hex, SHORT_SIZE, $prefixToRemove, true);

                $this->position += SHORT_SIZE;
                return $value;

            case 'float':
                $hex = substr($this->getHexString(), $this->position, LINT_SIZE);

                $this->parsedHex = $hex;
                $this->position += LINT_SIZE;
                return $this->toFloat($hex);
        }
    }

    private function getSkillsCount(string $field) : int
    {
        $this->skillsCount = $this->decodeType($field, 'int');
        $this->position += SUPER_INT_SIZE;

        return $this->skillsCount;
    }

    private function getSkills(string $field) : array
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

    private function getName(): string
    {
        $name = '';

        $nameLength = $this->nameLength / 2;

        for ($i = 0; $i < $nameLength; $i++) {
            $name .= chr($this->hexToDecimal(substr($this->getHexString(), $this->position + $i * INT_SIZE, 2), 2, 0, true));
        }

        $this->position += $nameLength * INT_SIZE;

        return $name;
    }

    private function packName() : string
    {
        $name = '';

        $initialPos = $this->position + INT_SIZE;
        
        for ($i = 0; $i < $this->nameLength; $i++) {
            $parsedHex = substr($this->getHexString(), $initialPos + $i * INT_SIZE + SHORT_SIZE, SHORT_SIZE);
            
            $name .= pack("H*", $parsedHex);
        }

        $this->position += SHORT_SIZE;

        return $name;
    }

    private function getAddonsCount(string $field): int
    {
        $this->addonsCount = $this->decodeType($field, 'lint');

        if ($this->addonsCount > 30)
            throw new \Exception('Invalid addons count, max value is 30, got ' . $this->addonsCount . ' instead');

        return $this->addonsCount;
    }

    private function getAddons()
    {
        $addons = [
            'special_addons' => [],
            'normal_addons' => [],
            'refine_addons' => [],
            'socket_addons' => [],
        ];

        if ($this->addonsCount <= 0) {
            return $addons;
        }

        $socketIndex = 0;
        $shift = 0;

        for ($i = 0; $i < $this->addonsCount; $i++) {
            $addonPos = $this->position + $i * SUPER_INT_SIZE + $shift;
            $hexString = substr($this->getHexString(), $addonPos, LINT_SIZE);
            $hexString = ltrim($this->reverseHexNumber($hexString), '0');

            if (strlen($hexString) % 2 != 0) {
                continue;
            }

            $hexString = trim($hexString);
            $addonType = substr($hexString, 0, 1);

            if ($addonType == SPECIAL_ADDON) {
                $addonId = $this->hexToDecimal($hexString, LINT_SIZE, $addonType, false);
                $addon = [
                    'id' => $addonId,
                    'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                    'level' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + SUPER_INT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                ];

                if ($addonId > 1691 && $addonId < 1892) {
                    $addons['refine_addons'] = $addon;
                } else {
                    $addons['special_addons'][] = $addon;
                }

                $shift += LINT_SIZE;
            } elseif ($addonType == SOCKET_ADDON) {
                $socketIndex++;
                $addonId = $this->hexToDecimal($hexString, LINT_SIZE, $addonType, false);
                $socketAddon = [
                    'index' => $socketIndex,
                    'id' => $addonId,
                    'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true),
                ];

                $addons['socket_addons'][] = $socketAddon;
            } else {
                $addonId = hexdec(substr($hexString, 1));
                $addon = [
                    'id' => $addonId,
                    'value' => intval($this->hexToDecimal(substr($this->getHexString(), $addonPos + LINT_SIZE, LINT_SIZE), LINT_SIZE, 0, true), 10),
                ];

                $addons['normal_addons'][] = $addon;
            }
        }

        return $addons;
    }

    private function getSocketsCount(string $field): int
    {
        $this->socketsCount = $this->decodeType($field, 'int');
        $this->position += INT_SIZE;

        return $this->socketsCount;
    }

    private function getSockets()
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

    private function getAttackRate(string $field): float
    {
        $attackRate = $this->decodeType($field, 'lint');
        if ($attackRate <= 0) return 0;

        $attackRate = ATTACK_RATE_FACTOR / $attackRate;
        return round($attackRate, 2);
    }

    private function getNameLength(string $field): int
    {
        $nameLength = $this->decodeType($field, 'short');
        $this->nameLength = $nameLength;

        return $nameLength;
    }

    private function getDurability(string $field): int
    {
        $durability = $this->decodeType($field, 'lint');

        return intval($durability / DURABILITY_DIVIDER);
    }

    private function reverseHexNumber($number)
    {
        return implode('', array_reverse(str_split($number, 2)));
    }

    private function toFloat(string $hex): float
    {
        $float_value = unpack("f", pack("H*", $hex))[1];
        return $float_value;
    }

    private function hexToDecimal(string $hexString, int $expectedLength, mixed $prefixToRemove = 0, bool $reverse = true)
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
