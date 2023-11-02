<?php

namespace App;

class Mask
{
    public const WEAPON = 0x00000001;
    public const HEAD = 0x00000002;
    public const NECK = 0x00000004;
    public const SHOULDER = 0x00000008;
    public const BODY = 0x00000010;
    public const WAIST = 0x00000020;
    public const LEG = 0x00000040;
    public const FOOT = 0x00000080;
    public const WRIST = 0x00000100;
    public const FINGER1 = 0x00000200;
    public const FINGER2 = 0x00000400;
    public const PROJECTILE = 0x00000800;
    public const FLYSWORD = 0x00001000;
    public const FASHION_BODY = 0x00002000;
    public const FASHION_LEG = 0x00004000;
    public const FASHION_FOOT = 0x00008000;
    public const FASHION_WRIST = 0x00010000;
    public const ATTACK_RUNE = 0x00020000;
    public const BIBLE = 0x00040000;
    public const BUGLE = 0x00080000;
    public const HP_ADDON = 0x00100000;
    public const MP_ADDON = 0x00200000;
    public const TWEAK = 0x00400000;
    public const ELF = 0x00800000;
    public const STALLCARD = 0x01000000;
    public const FASHION_HEAD = 0x02000000;
    public const FORCE_TICKET = 0x04000000;
    public const DYNSKILL0 = 0x08000000;
    public const DYNSKILL1 = 0x10000000;
    public const FASHION_WEAPON = 0x20000000;
    public const UNUSED1 = 0x40000000;
    public const UNUSED2 = 0x80000000;
    public const GENERALCARD1 = 0x0000000100000000;
    public const GENERALCARD2 = 0x0000000200000000;
    public const GENERALCARD3 = 0x0000000400000000;
    public const GENERALCARD4 = 0x0000000800000000;
    public const GENERALCARD5 = 0x0000001000000000;
    public const GENERALCARD6 = 0x0000002000000000;
    public const CAN_BIND = 0x220DF7FF;
    public const SECURITY_PASSWD_PROTECTED = 0x2205F7FF;
    public const DYNSKILL_ALL = 0x18000000;

    public static function decode(int $mask) : array
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();

        $flags = [];

        foreach ($constants as $key => $value)
        {
            if (($mask & $value) === $value)
            {
                $flags[] = $key;
                $mask -= $value;
            }
        }

        return $flags;
    }

    public static function getEquipmentTypeFromMask(int $mask) : int
    {
        $maskFlags = self::decode($mask);
        $type = $maskFlags[0] ?? null;

        if (!defined("self::$type")) {
            throw new \Exception("Invalid mask or type {$type} not defined!");
        }

        $value = constant("self::$type");
        return self::getEquipmentTypes()[$value] ?? 0;
    }

    public static function getEquipmentTypes() : array
    {
        return [
            self::WEAPON => 'Weapon',
            self::HEAD => 'Armor',
            self::NECK => 'Jewelry',
            self::SHOULDER => 'Armor',
            self::BODY => 'Armor',
            self::WAIST => 'Armor',
            self::LEG => 'Armor',
            self::FOOT => 'Armor',
            self::WRIST => 'Armor',
            self::FINGER1 => 'Jewelry',
            self::FINGER2 => 'Jewelry',
            self::PROJECTILE => 'Ammo',
            self::FLYSWORD => 'Flight',
            self::FASHION_BODY => 'Fashion',
            self::FASHION_LEG => 'Fashion',
            self::FASHION_FOOT => 'Fashion',
            self::FASHION_WRIST => 'Fashion',
            self::ATTACK_RUNE => 'AttackCharm',
            self::BIBLE => 'Bible',
            self::BUGLE => 'Bugle',
            self::HP_ADDON => 'Charm',
            self::MP_ADDON => 'Charm',
            self::TWEAK => 'Armor',
            self::ELF => 'Genie',
            self::STALLCARD => 'StallCard',
            self::FASHION_HEAD => 'Fashion',
            self::FORCE_TICKET => 'ForceTicket',
            self::DYNSKILL0 => 'DynSkill',
            self::DYNSKILL1 => 'DynSkill',
            self::FASHION_WEAPON => 'Fashion',
            self::UNUSED1 => 'Unequippable',
            self::UNUSED2 => 'Unequippable',
            self::GENERALCARD1 => 'Card',
            self::GENERALCARD2 => 'Card',
            self::GENERALCARD3 => 'Card',
            self::GENERALCARD4 => 'Card',
            self::GENERALCARD5 => 'Card',
            self::GENERALCARD6 => 'Card',
            self::CAN_BIND => 'Unequippable',
            self::SECURITY_PASSWD_PROTECTED => 'Unequippable',
            self::DYNSKILL_ALL => 'DynSkill',
        ];
    }
}
