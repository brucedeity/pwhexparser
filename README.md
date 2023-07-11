# PWHexParser

This is a PHP library for decoding PW's item's hexadecimal strings based on their predefined structure.

## Features

- Decode the structure for Weapon, Armor, Fashion, Jewelry, Flight and much more
- Retrieve the decoded data as json
- Error handling and validation for input data

## Example

Here's an example usage of the PWHexParser library:

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$decoder = new App\Decoder();
$decoder->setItemType('Fashion'); // Weapon, Armor, Charm, Jewelry, Flight, Card...
$decoder->sethexString('1e00000092470100010a620072007500630065000000'); //Mandarin Silk Gown
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
```

### Which will output:

```php
{
  "level_req": 30,
  "color": 18322,
  "gender": 1,
  "creator_type": 1,
  "name_length": 5,
  "name": "bruce",
  "color_mask": 0
}
```


### Guessing item type:

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

$mask = 1;

$decoder = new App\Decoder();
$decoder->guessItemType($mask);
$decoder->sethexString('5a00ff001001000031000000b4610000786900002c00040a4200720075006300650000000000090000000b00000000000000930200009b0500000000000000000000180000000000604000000000010000000000000003000000114500009200000001000000f02300004d000000cf2500000e000000');
$result = $decoder->decodeHexString();

header('Content-Type: application/json');
echo json_encode($result, JSON_PRETTY_PRINT);
```

### Output:

```php
{
  "level": 90,
  "class": 255,
  "strength": 272,
  "vitality": 0,
  "dexterity": 49,
  "magic": 0,
  "min_durability": 250,
  "max_durability": 270,
  "item_type": 44,
  "item_flag": 4,
  "name_length": 10,
  "name": "Bruce",
  "ranged_type": 0,
  "weapon_type": 9,
  "weapon_grade": 11,
  "ammunition_type": 0,
  "min_physical_damage": 659,
  "max_physical_damage": 1435,
  "min_magic_damage": 0,
  "max_magic_damage": 0,
  "attack_rate": 0.83,
  "attack_range": 3.5,
  "minimum_effective_range": 0,
  "sockets_count": 1,
  "sockets": [
    0
  ],
  "addons_count": 3,
  "addons": {
    "special_addons": [
      {
        "id": 1297,
        "value": 146,
        "level": 1
      }
    ],
    "normal_addons": [
      {
        "id": 1008,
        "value": 77
      },
      {
        "id": 1487,
        "value": 14
      }
    ],
    "refine": [
      
    ],
    "socket": [
      
    ]
  }
}
```