<?php
const BR = '<br>';

$name = "John";
$Name = "Sega";
$NAME = "Marian";

echo "name = $name, Name = $Name, NAME = $NAME".BR;

$int = sqrt(32);
var_dump($int);

$age = 33;
$eval = $age > 21 ? "You can buy wojak!."
                  : "You can't buy wojak";
echo $eval.BR;

$$Name = '16-bit console';
echo $Sega.BR;
echo $Name.BR;

$copy = &$Name;
$copy .= "aa";
echo $copy.BR;
echo $Name.BR;
unset($Name);
echo $copy.BR;
echo $Name;

// is_array()
echo gettype($name);

