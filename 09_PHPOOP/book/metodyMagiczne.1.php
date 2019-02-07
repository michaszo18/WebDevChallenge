<?php

class Komputery {
    private $nazwa = '';
    private $dodatkoweFunkcje = array();


    function __construct($nazwa)
    {
        $this->nazwa = $nazwa;
    }

    public function getNazwa()
    {
        return $this->nazwa;
    }

    public function __toString()
    {
        return PrzedstawSie();
    }

    public function __set($co, $wartosc)
    {
        $this->dodatkoweFunkcje[$co] = $wartosc;
        echo "Moja nowa dodatowa funkcja ta: $co <br>";
    }

    public function __get($co)
    {
        return $this->dodatkoweFunkcje[$co];
    }

    public function __invoke()
    {
        echo $this->getNazwa() . " ZGŁASZA SIĘ!! <br>";
    }

    public function PrzedstawSie()
    {
        echo $this->getNazwa() . "<br>";
        echo "Moje funkcje to: ";
        foreach ($dodatkoweFunkcje as $key => $value) {
            echo "Funkcja: $key - robi: $value <br>";
        }
    }
}

$lenovo = new Komputery("Lenovo");
$thinkPad = new Komputery("ThinkPad");


$lenovo();
$lenovo->wlaczSie = "Wlaczony";
$lenovo->wylaczSie = "Wylaczony";

echo $lenovo;
