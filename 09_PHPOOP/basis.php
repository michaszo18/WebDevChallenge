<?php
$game_name = 'Mass Effect 3';
$release_year = 2013;
$cost_now = 11.96;
$awesome = true;

const BR = '<br>';
define('RELEASE_YEAR', 2013);
echo "Title $game_name was released in $release_year".BR;

$num = '100.11';
var_dump(+$num);

$game_genres = array('rpg', 'adv', 'action', 'strategy', array('mmo', 'mmorpg'), 'puzzle');
//echo $game_genres[0];
//echo BR;
//echo $game_genres[4][0];

$years = ['StarCraft' => 1998, 'The Witcher' => 2009, 'Mass Effect 3' => RELEASE_YEAR];

pre_r($years);
pre_r($game_genres);

function pre_r($arr) {
    echo '<pre>';
        print_r($arr);
    echo '</pre>';
}

$age = 23;

if($age > 18 and $age <= 30) {
    echo "You have $age :)";
} else {
    echo "You have $age";
}

for ($key = 0; $key < count($game_genres); $key++) {
    if(is_array($game_genres[$key])) {
        echo count($game_genres[$key]);
        for ($key2 = 0; $key2 < count($game_genres[$key]); $key2++) {
            echo BR.$game_genres[$key][$key2];
        }
    } else {
        echo BR.$game_genres[$key];
    }
}

foreach ($years as $game => $year) {
    echo BR."$game was released in $year".BR;
}

class Car {
    var $make;
    var $type;
    var $color;
    var $max_speed;

    const BRC = '<br>';
    const STRONG = ['<strong>', '</strong>'];

    function stop() {
        echo "Stopping....".BR;
    }

    function accelerate() {
        echo "The $this->color $this->make $this->type is now accelerating...".self::BRC;
    }

    function print_info() {
        echo "Here is the info about the car".self::BRC;
        echo self::STRONG[0]."Make: $this->make".self::STRONG[1].self::BRC;
        echo self::STRONG[0]."Type: $this->type".self::STRONG[1].self::BRC;
        echo self::STRONG[0]."Color: $this->color".self::STRONG[1].self::BRC;
        echo self::STRONG[0]."Max speed: $this->max_speed".self::STRONG[1].self::BRC;
    }
}

echo BR.BR.BR;

$acura = new Car();
$acura->make = 'Acura';
$acura->color = 'Black';
$acura->max_speed = 280;
$acura->type= 'RSX';

$acura->stop();
$acura->accelerate();
$acura->print_info();