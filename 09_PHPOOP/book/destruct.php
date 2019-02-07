<?php


// Metoda __destruct() zostanie wywołana tuż przed usunięciem obiektu klasy Person z pamięci . To zaś następuje
// albo w wyniku jawnego wywołania funkcji unset(), albo kiedy w bieżącym procesie nie ostanie się już żadna
// referencja obiektu
class Person
{
    private $name;
    private $age;
    private $id;

    function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function __destruct()
    {
        if (!empty($this->id)) {
            // Utrwal dane obiektu…
            // print "Dane obiektu utrwalone\n";
        }
    }

    public function __toString()
    {
        return "$this->name _ $this->age _ $this->id <br>";
    }

    public function __clone()
    {
        $this->id = 0;
    }
}

$person = new Person("person", 44);
$person->setId(343);
$person2 = clone $person;

echo $person;
echo $person2;