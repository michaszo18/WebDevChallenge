<?php

class ShopProduct {
    private $title               = "bez tytułu";
    private $producerMainName    = "nazwisko";
    private $producerFirstName   = "imię";
    protected $price             = 0;
    private $discount            = 0;

    public function __construct($title, $firstName, $mainName, $price) {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducer() {
        return "{$this->producerFirstName} ".
               "{$this->producerMainName}";
    }

    public function getSummaryLine() {
        $base = "{$this->title} ({$this->producerMainName}, ";
        $base .= "{$this->producerFirstName})";
        return $base;
    }

    public function setDiscount($num) {
        $this->discount = $num;
    }

    public function getPrice() {
        return ($this->price - $this->discount);
    }
}

class CdProduct extends ShopProduct {

    private $playLength;

    public function __construct($title, $firstName, $mainName, $price, $playLength) {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }

    public function getPlayLength() {
        return $this->playLength;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": czas trwania - {$this->playLength}";
        return $base;
    }
}

class BookProduct extends ShopProduct {

    private $numPages;

    public function __construct($title, $firstName, $mainName, $price, $numPages) {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    public function getNumberOfPages() {
        return $this->numPages;
    }

    public function getSummaryLine() {
        $base = parent::getSummaryLine();
        $base .= ": liczba stron - {$this->numPages}";
        return $base;
    }

    public function getPrice() {
        return $this->price;
    }
}


// Uwaga Metodę write() można by dodać bezpośrednio do klasy ShopProduct. Nie zrobimy tego jednak ze względu na
// podział odpowiedzialności. Klasa ShopProduct ma realizować zadania zarządzania danymi produktów; za wypisywanie
// danych o produktach odpowiedzialna jest klasa ShopProductWriter.
class ShopProductWriter {

    private $products = array();

    public function addProduct(ShopProduct $shopProduct) {
        $this->products[] = $shopProduct;
    }

    public function write() {
        $str = "";
        foreach ($this->products as $shopProduct) {
            $str .= "{$shopProduct->title}: ";
            $str .= $shopProduct->getProducer();
            $str .= " ({$shopProduct->getPrice()}PLN) <br>";
        }
        print $str;
    }
}


$product1 = new BookProduct("Dziady", "Adam", "Mickiewicz", 40.99, 760);
$product2 = new CdProduct("Dolina klaunoow", "Trzeci", "Wymiar", 29.99, 50);
// var_dump($product1);
// unset($product1);
// var_dump($product1);
// print "Autor: {$product1->getProducer()}\n";

// $writer->write($product1);
// $writer->write($product2);

$product2->setDiscount(15);
// echo "product2 -> getPrice: " . $product2->getPrice() . "<br>";

// echo $product1->getSummaryLine() . "<br>";
// echo $product2->getSummaryLine();
$writer = new ShopProductWriter();
$writer->addProduct($product1);
$writer->addProduct($product2);
$writer->write();

// str 50