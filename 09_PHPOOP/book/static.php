<?php


// późnego wiązania składowych statycznych . Najważniejszym objawem
// działania tego mechanizmu jest nowe słowo kluczowe języka : static . Słowo to ma znaczenie podobne do self,
// ale odnosi się do kontekstu użycia, a nie do kontekstu klasy zawierającej użycie . W naszym przypadku użycie
// słowa static oznaczałoby, że wywołanie metody Document::create() utworzyłoby nowy obiekt klasy Document,
// ale nie stanowiłoby próby utworzenia obiektu klasy DomainObject
abstract class DomainObject {

    private $group;

    public function __construct()
    {
        $this->group = static::getGroup();
    }

    public static function create()
    {
        return new static();
    }

    static function getGroup()
    {
        return 'default';
    }
}

class User extends DomainObject {
}

class Documnet extends DomainObject {
    static function getGroup()
    {
        return 'document';
    }
}

class SpreadSheet extends Documnet {

}

print_r(Documnet::create());
print_r(User::create());
print_r(SpreadSheet::create());

// do klasy DomainObject wprowadziliśmy konstruktor . Wykorzystujemy w nim słowo static do wywołania
// metody statycznej getGroup() . Klasa DomainObject zawiera domyślną implementację tej metody, ale w klasie
// Document zostaje ona przesłonięta inną wersją . Utworzyliśmy też nową klasę SpreadSheet, która rozszerza
// klasę Document .