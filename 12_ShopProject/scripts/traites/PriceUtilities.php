<?php
namespace shop;

trait PriceUtilities {
    private $taxrate = 17;

    function calculateTax($price)
    {
        return (($this->taxrate/100) * $price);
    }
}