<?php
class Account
{
    private $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }

    public function setBalance($a)
    {
        $this->balance += $a;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function __toString()
    {
        return " " . $this->getBalance();
    }
}

class Person
{
    private $name;
    private $age;
    private $id;
    public $account;

    function __construct($name, $age, Account $account)
    {
        $this->name = $name;
        $this->age = $age;
        $this->account = $account;
    }
    function setId($id)
    {
        $this->id = $id;
    }
    function __clone()
    {
        $this->id = 0;
        $this->account = clone $this->account;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getAccount()
    {
        return $this->account;
    }

    function __toString()
    {
        $desc = $this->getName();
        $desc .= " (wiek: " . $this->getAge() . ")";
        $desc .= " Stan konta: " . $this->getAccount();
        return $desc;
    }
}

$person = new Person("Mike", 23, new Account(2000000));
$person->setId(001);
$person2 = clone $person;


echo $person;