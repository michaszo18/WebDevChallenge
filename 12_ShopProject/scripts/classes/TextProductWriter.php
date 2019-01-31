<?php

namespace shop;

require_once 'ShopProductWriter.php';

class TextProductWriter extends ShopProductWriter
{
    use PriceUtilities;

    public function write()
    {
        $str = "PRODUCTS: <br>";
        foreach ($this->products as $shopProduct) {
            $str .= $shopProduct->getSummaryLine() . "<br>";
        }
        echo $str;
    }
}
