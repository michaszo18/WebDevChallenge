<?php
namespace shop;

// require_once 'scripts\classes\ShopProduct.php';
require_once 'scripts\classes\BookProduct.php';
require_once 'scripts\classes\CdProduct.php';
require_once 'scripts\classes\TextProductWriter.php';
require_once 'scripts\classes\XmlProductWriter.php';


$product1 = new BookProduct("Dziady", "Adam", "Mickiewicz", 40.99, 760);
$product2 = new CdProduct("Dolina klaunoow", "Trzeci", "Wymiar", 29.99, 50);
// var_dump($product1);
// unset($product1);
// var_dump($product1);
// print "Autor: {$product1->getProducer()}\n";

$product2->setDiscount(15);
// echo "product2 -> getPrice: " . $product2->getPrice() . "<br>";
// echo $product1->getSummaryLine() . "<br>";
// echo $product2->getSummaryLine();
$textWriter = new TextProductWriter();
$XmlProductWriter = new XmlProductWriter();

$textWriter->addProduct($product1);
$textWriter->addProduct($product2);

$XmlProductWriter->addProduct($product1);
$XmlProductWriter->addProduct($product2);



$textWriter->write();

