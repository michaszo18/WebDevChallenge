<?php
namespace shop;
require_once 'ShopProduct.php';

class CdProduct extends ShopProduct
{

    private $playLength;

    public function __construct($title, $firstName, $mainName, $price, $playLength)
    {
        parent::__construct($title, $firstName, $mainName, $price);
        $this->playLength = $playLength;
    }

    public function getPlayLength()
    {
        return $this->playLength;
    }

    public function getSummaryLine()
    {
        $base = parent::getSummaryLine();
        $base .= ": czas trwania - {$this->playLength}";
        return $base;
    }
}
