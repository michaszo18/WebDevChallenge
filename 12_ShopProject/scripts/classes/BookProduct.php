<?php
namespace shop;

require_once 'ShopProduct.php';

class BookProduct extends ShopProduct
{

    private $numPages;

    public function __construct($title, $firstName, $mainName, $price, $numPages)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->numPages = $numPages;
    }

    public function getNumberOfPages()
    {
        return $this->numPages;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ": liczba stron - {$this->numPages}";
        return $base;
    }

    public function getPrice()
    {
        return $this->price;
    }
}