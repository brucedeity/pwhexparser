<?php

namespace App;

use App\Contracts\Translate;
use App\Types\Unequippable;
use App\Types\Bible;
use App\Types\DynSKill;
use Exception;
use App\Mask;

class Decoder
{
    private $position = 0;
    private $hexString = '';
    private $parsedHex = '';
    private $lang = 'pt-BR';
    private $nameLength = 0;
    private $socketsCount = 0;
    private $addonsCount = 0;
    private $skillsCount = 0;
    private Translate $itemType;

    const SHORT = 2;
    const INT = 4;
    const INT8 = 8;
    const MAX_SOCKETS_COUNT = 4;
    const ATTACK_RATE_FACTOR = 20;
    const SPECIAL_ADDON_ID = 4;
    const SOCKET_ADDON_ID = 'a';
    const DURABILITY_DIVIDER = 100;

    public function sethexString(string $hexString): void
    {
        $this->hexString = $hexString;
    }

    public function setLang(string $lang = 'pt-BR') : void
    {
        $this->getItemType()->setLang($lang);
    }

    public function translate()
    {
        try {
            $structure = $this->getItemType()->getTranslatedStructure();
            $values = $this->decode();
            $result = [];

            foreach ($structure as $field => $translatedField) {
                if (is_array($translatedField)) {
                    if (
                        isset($translatedField['name'], $translatedField['values'][0], $translatedField['values'][1]) &&
                        isset($values[$translatedField['values'][0]], $values[$translatedField['values'][1]])
                    ) {
                        $result[$field] = [
                            'translated' => $translatedField['name'],
                            'value' => $values[$translatedField['values'][0]] . $translatedField['separator'] . $values[$translatedField['values'][1]]
                        ];
                    } else {
                        throw new Exception("Invalid structure or missing values for translation");
                    }
                } else {
                    if (isset($values[$field])) {
                        $result[$field] = [
                            'translated' => $translatedField,
                            'value' => $values[$field]
                        ];
                    } else {
                        throw new Exception("Missing value for field: $field");
                    }
                }
            }

            return $result;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function gethexString(): string
    {
        return $this->hexString;
    }

    private function validateItemType(string $type) : bool
    {
        foreach (Mask::getEquipmentTypes() as $key => $availableType)
        {
            if ($availableType === $type) {
                return true;
            }
        }

        return false;
    }

    public function setItemType(string $itemType): void
    {
        if (!$this->validateItemType($itemType) && $itemType != 'Property') throw new Exception('Invalid item type: ' . $itemType);

        $itemTypeObject = 'App\Types\\' . $itemType;

        $this->itemType = new $itemTypeObject();
    }

    public function guessItemType(int $mask) : void
    {
        $type = Mask::getEquipmentTypeFromMask($mask);

        $this->setItemType($type);
    }

    public function getItemType(): Translate
    {
        return $this->itemType;
    }

    private function validateHex(&$error) : bool
    {
        if (empty($this->getHexString())) {
            $error = 'Hex string not set, please use setHexString(). Item type: '. get_class($this->itemType);

            return false;
        }

        if (!ctype_xdigit($this->getHexString())) {
            $error = 'Invalid hexadecimal string for type '. get_class($this->itemType);

            return false;
        }

        if ($this->getItemType() === null) {
            $error = 'Item type not set, please use setItemType() method before calling decode()';

            return false;
        }

        if (strlen($this->getHexString()) < $this->getItemType()->getMinimumLength()) {
            $error = 'Hex string is too short for ' . get_class($this->itemType) . ', given: ' . strlen($this->getHexString()) . ', expected: ' . $this->getItemType()->getMinimumLength();

            return false;
        }

        return true;
    }

    public function decode(): array
    {
        if ($this->itemType instanceof Unequippable) {
            return [];
        }

        try
        {
            $error = '';

            if (!$this->validateHex($error)) {
                return [
                    'error' => "Error while validating hex: {$error}"
                ];
            }

            $structure = $this->getItemType()->getStructure();
            $result = $this->decodeStructure($structure);

            return $result;
        }
        catch (Exception $e)
        {
            return [
                'error' => 'Exception while decoding hex: ' . $e->getMessage()
            ];
        }
    }

    private function decodeStructure(array $structure): array
    {
        $result = [];
        foreach ($structure as $field => $type) {
            $result[$field] = $this->decodeType($field, $type);
        }
        return $result;
    }

    public function debugHexString(): array
    {
        if ($this->itemType instanceof Unequippable ) {
            return [];
        }

        $error = '';

        if (!$this->validateHex($error)) {
            return [
                'error' => "Error while validating hex for debug: {$error}"
            ];
        }

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
                $hex = substr($this->getHexString(), $this->position, self::INT);
                $this->parsedHex = $hex;
                $this->position += self::INT;
                return $this->hexToDecimal($hex, self::INT, $prefixToRemove, true);

            case 'int8':
                $hex = substr($this->getHexString(), $this->position, self::INT8);
                $this->parsedHex = $hex;
                $this->position += self::INT8;
                return $this->hexToDecimal($hex, self::INT8, $prefixToRemove, true);

            case 'short':
                $hex = substr($this->getHexString(), $this->position, self::SHORT);
                $this->parsedHex = $hex;
                $value = $this->hexToDecimal($hex, self::SHORT, $prefixToRemove, true);

                $this->position += self::SHORT;
                return $value;

            case 'float':
                $hex = substr($this->getHexString(), $this->position, self::INT8);

                $this->parsedHex = $hex;
                $this->position += self::INT8;
                return $this->toFloat($hex);
        }
    }

    private function getSkillsCount(string $field) : int
    {
        $this->skillsCount = $this->decodeType($field, 'int');
        $this->position += (self::INT * 4);

        return $this->skillsCount;
    }

    private function getSkills(string $field) : array
    {
        $skills = [];

        for ($i = 0; $i < $this->skillsCount; $i++) {

            $skillPos = $this->position + (self::INT * 4) + ($i * (self::INT * 4));

            $skill = [
                'id' => $this->hexToDecimal(substr($this->getHexString(), $skillPos, self::INT8), self::INT8, 0, true),
                'level' => $this->hexToDecimal(substr($this->getHexString(), $skillPos + self::INT8, self::INT8), self::INT8, 0, true),
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
            $name .= chr($this->hexToDecimal(substr($this->getHexString(), $this->position + $i * self::INT, 2), 2, 0, true));
        }

        $this->position += $nameLength * self::INT;

        return $name;
    }

    private function packName() : string
    {
        $name = '';

        $initialPos = $this->position + self::INT;

        for ($i = 0; $i < $this->nameLength; $i++) {
            $parsedHex = substr($this->getHexString(), $initialPos + $i * self::INT + self::SHORT, self::SHORT);

            $name .= pack("H*", $parsedHex);
        }

        $this->position += self::SHORT;

        return $name;
    }

    private function getAddonsCount(string $field): int
    {
        $this->addonsCount = $this->decodeType($field, 'int8');

        if ($this->addonsCount > 30)
            throw new Exception('Invalid addons count, max value is 30, got ' . $this->addonsCount . ' instead');

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
            $addonPos = $this->position + $i * (self::INT * 4) + $shift;
            $hexString = substr($this->getHexString(), $addonPos, self::INT8);
            $hexString = ltrim($this->reverseHexNumber($hexString), '0');

            if (strlen($hexString) % 2 != 0) {
                continue;
            }

            $hexString = trim($hexString);
            $addonType = substr($hexString, 0, 1);

            if ($addonType == self::SPECIAL_ADDON_ID) {
                $addonId = $this->hexToDecimal($hexString, self::INT8, $addonType, false);
                $addon = [
                    'id' => $addonId,
                    'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + self::INT8, self::INT8), self::INT8, 0, true),
                    'level' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + (self::INT * 4), self::INT8), self::INT8, 0, true),
                ];

                if ($addonId > 1691 && $addonId < 1892) {
                    $addons['refine_addons'] = $addon;
                } else {
                    $addons['special_addons'][] = $addon;
                }

                $shift += self::INT8;
            } elseif ($addonType == self::SOCKET_ADDON_ID) {
                $socketIndex++;
                $addonId = $this->hexToDecimal($hexString, self::INT8, $addonType, false);
                $socketAddon = [
                    'index' => $socketIndex,
                    'id' => $addonId,
                    'value' => $this->hexToDecimal(substr($this->getHexString(), $addonPos + self::INT8, self::INT8), self::INT8, 0, true),
                ];

                $addons['socket_addons'][] = $socketAddon;
            } else {
                $addonId = hexdec(substr($hexString, 1));
                $addon = [
                    'id' => $addonId,
                    'value' => intval($this->hexToDecimal(substr($this->getHexString(), $addonPos + self::INT8, self::INT8), self::INT8, 0, true), 10),
                ];

                $addons['normal_addons'][] = $addon;
            }
        }

        return $addons;
    }

    private function getSocketsCount(string $field): int
    {
        $this->socketsCount = $this->decodeType($field, 'int');
        $this->position += self::INT;

        return $this->socketsCount;
    }

    private function getSockets()
    {
        $sockets = [];

        if ($this->socketsCount <= 0) {
            return $sockets;
        } elseif ($this->socketsCount > self::MAX_SOCKETS_COUNT) {
            throw new Exception('Invalid sockets count, max value is '.self::MAX_SOCKETS_COUNT.', got ' . $this->socketsCount . ' instead');
        }

        for ($i = 0; $i < $this->socketsCount; $i++) {
            $hex = $this->position + $i * self::INT8;
            $hex = substr($this->getHexString(), $hex, self::INT8);

            $sockets[$i] = $this->decodeType($hex, 'int8');
        }

        return $sockets;
    }

    private function getAttackRate(string $field): float
    {
        $attackRate = $this->decodeType($field, 'int8');
        if ($attackRate <= 0) return 0;

        $attackRate = self::ATTACK_RATE_FACTOR / $attackRate;
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
        $durability = $this->decodeType($field, 'int8');

        return intval($durability / self::DURABILITY_DIVIDER);
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

    private function hexToDecimal(string $hexString, int $expectedLength, mixed $prefixToRemove = NULL, bool $reverse = true)
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

    public function reset() : void
    {
        $this->position = 0;
        $this->hexString = '';
        $this->parsedHex = '';
        $this->nameLength = 0;
        $this->socketsCount = 0;
        $this->addonsCount = 0;
        $this->skillsCount = 0;
    }
}
