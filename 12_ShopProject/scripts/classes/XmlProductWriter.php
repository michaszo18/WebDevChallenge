<?php

namespace shop;
require_once 'ShopProductWriter.php';

class XmlProductWriter extends ShopProductWriter
{
    public function write()
    {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement("products");

        foreach ($this->products as $shopProduct) {
            $writer->startElement("product");
            $writer->writeAttribute("title", $shopProduct->getTitle());
            $writer->startElement("summary");
            $writer->text($shopProduct->getSummaryLine());
            $writer->endElement(); // element summary
            $writer->endElement(); // element product
        }

        $writer->endElement(); // element products
        $writer->endDocument();
        echo $writer->flush();
    }
}