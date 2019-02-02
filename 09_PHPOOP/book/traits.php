<?php

const BR = "<br>";

interface IdentityObject {
    public function generateId();
}

trait IdentityTrait {
    public function generateId()
    {
        return uniqid('');
    }
}

// trait TaxTools {
//     function calculateTax($price) {
//         return 222;
//     }

// }

trait PriceUtilities
{
    function calculateTax($price)
    {
        return (($this->getTaxRate() / 100) * $price) . " (PLN)";
    }
    abstract function getTaxRate();
 // inne składowe
}

abstract class Service
{
 // składowe i metody do obsługi klas hierarchii Service
}

class UtilityService extends Service
{
    // Aby deklarację use uzupełnić o dodatkowe dyrektywy, należy ująć je w nawiasy klamrowe wyznaczające
    // ciało deklaracji use . We wnętrzu tego bloku można użyć operatora insteadof, wymagającego podania po lewej
    // stronie pełnej kwalifikowanej nazwy metody (to znaczy nazwy metody z nazwą klasy rozdzielonych operatorem
    // zakresu) . Po prawej stronie insteadof podaje się nazwę cechy typowej, która zostanie zasłonięta w kontekście
    // tej metody .
    use PriceUtilities {
        // TaxTools::calculateTax insteadof PriceUtilities;
        // PriceUtilities::calculateTax insteadof TaxTools;
        PriceUtilities::calculateTax as private;
    }

    private $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    function getTaxRate() {
        return 23;
    }

    public function getFinalPrice()
    {
        return ((float)$this->calculateTax($this->price) + (float)$this->price);
    }
}

function storeIdentityObject(IdentityObject $idobj)
{
 // operacje na egzemplarzu typu IdentityObject
}

// $p = new ShopProduct();
// storeIdentityObject($p);
$u = new UtilityService(100);
print $u->getFinalPrice() . BR;

// echo "U (TaxTools::calculateTax): " . $u->calculateTax(100) . BR;

// echo "U (PriceUtilities::calculateTax as basicTax): " . $u->basicTax(100) . BR;
// $milk = new ShopProduct();
// echo "Milk tax: " . $milk->calculateTax(3.4) . BR;
// echo $milk->generateId() . BR;

