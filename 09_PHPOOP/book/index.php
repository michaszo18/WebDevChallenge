<?php
// Cechy typowe są co prawda użyteczne, ale nie wpływają na typ klasy, do której są włączane . Jeśli więc dołączymy
// cechę typową IdentityTrait do wielu klas, nie będą to klasy zgodne co do typu, co umożliwiłoby ich grupowe
// określanie w oznaczeniach typów parametrów metod innych klas .
// Na szczęście cechy typowe współgrają z interfejsami . Można więc zdefiniować interfejs wymagający
// metod generateId(), a następnie zadeklarować klasę ShopProduct jako implementującą ten interfejs(za pośrednictwem cechy typowej) :
interface IdentityObject {
    public function generateId();
}

interface Chargeable
{
    public function getPrice();
}

trait PriceUtilities {
    private $taxrate = 17;

    function calculateTax($price)
    {
        return (($this->taxrate/100) * $price);
    }
}

trait IdentityTrait {
    public function generateId() {
        return uniqid();
    }
}

abstract class Service {

}

class UtilityService extends Service {
    use PriceUtilities;
}


class ShopProduct implements Chargeable, IdentityObject
{
    use PriceUtilities, IdentityTrait;

    const AVAILABLE = 0;
    const OUT_OF_STOCK = 1;

    private $title = "bez tytułu";
    private $producerMainName = "nazwisko";
    private $producerFirstName = "imię";
    protected $price = 0;
    private $discount = 0;

    public function __construct($title, $firstName, $mainName, $price)
    {
        $this->title = $title;
        $this->producerFirstName = $firstName;
        $this->producerMainName = $mainName;
        $this->price = $price;
    }

    public function getProducer()
    {
        return "{$this->producerFirstName} " .
            "{$this->producerMainName}";
    }

    public function getSummaryLine()
    {
        $base = "{$this->title} ({$this->producerMainName}, ";
        $base .= "{$this->producerFirstName})";
        return $base;
    }

    public function setDiscount($num)
    {
        $this->discount = $num;
    }

    public function getPrice()
    {
        return ($this->price - $this->discount);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    // Ta metoda jest bardziej przydatna w kontekście klasy niż w kontekście obiektu . Pozwala bowiem łatwo przekładać
    // dane z bazy danych do postaci obiektów . Metoda nie odwołuje się do składowych czy metod konkretnego
    // egzemplarza, zanim sama tego egzemplarza nie utworzy — nie ma więc najmniejszego powodu, aby nie
    // oznaczyć jej jako statycznej .
    public static function getInstance($id, PDO $pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $result = $stmt->execute(array($id));
        $row = $stmt->fetch();

        if (empty($row)) {
            return null;
        }

        if ($row['type'] === "ksiazka") {
            $product = new BookProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['numpages']
            );
        } else if ($row['type'] == "cd") {
            $product = new CdProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price'],
                $row['playlength']
            );
        } else {
            $product = new ShopProduct(
                $row['title'],
                $row['firstname'],
                $row['mainname'],
                $row['price']
            );
        }

        $product->setId($row['id']);
        $product->setDiscount($row['discount']);
        return $product;
    }
}

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


// Uwaga Metodę write() można by dodać bezpośrednio do klasy ShopProduct. Nie zrobimy tego jednak ze względu na
// podział odpowiedzialności. Klasa ShopProduct ma realizować zadania zarządzania danymi produktów; za wypisywanie
// danych o produktach odpowiedzialna jest klasa ShopProductWriter.
abstract class ShopProductWriter
{
    protected $products = array();

    public function addProduct(ShopProduct $shopProduct)
    {
        $this->products[] = $shopProduct;
    }

    abstract public function write();
}

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

$dsn = "sqlite:oop.db";
$pdo = new PDO($dsn, null, null);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$obj = ShopProduct::getInstance(2, $pdo);

$textWriter->addProduct($obj);

$textWriter->write();
// $XmlProductWriter->write();

echo $product1->calculateTax($product1->getPrice()) . "<br>";
echo $product1->generateId() . "<br>";
// print ShopProduct::AVAILABLE;
