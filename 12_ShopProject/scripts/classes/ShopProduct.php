<?php
namespace shop;

require_once 'scripts\traites\PriceUtilities.php';
require_once 'scripts\interfaces\Chargeable.php';

class ShopProduct implements Chargeable
{
    use PriceUtilities;

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