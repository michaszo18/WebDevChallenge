<?php
class Product
{
    public $name;
    public $price;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}
class ProcessSale
{
    private $callbacks;

    function registerCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception("niepoprawne wywołanie zwrotne");
        }
        $this->callbacks[] = $callback;
    }

    function sale($product)
    {
        print "{$product->name}: przetwarzanie sprzedaży \n";
        foreach ($this->callbacks as $callback) {
            call_user_func($callback, $product);
        }
    }
}


// create_function() . Jak widać, funkcja ta przyjmuje
// dwa argumenty(ciągi znaków) . Pierwszy z nich określa listę parametrów montowanej funkcji, a drugi to ciało
// funkcji . Wynikiem wykonania create_function() jest tak zwana funkcja anonimowa, a więc nieposiadająca
// nazwy tak jak klasyczna funkcja PHP . Może jednak być reprezentowana w zmiennej i przekazywana do funkcji
// w roli argumentu wywołania

$logger = create_function(
    '$product',
    'print " zapisano ({$product->name}) <br>";'
);

$processor = new ProcessSale();
$processor->registerCallback($logger);
$processor->sale(new Product("buty", 6));
print "\n";
$processor->sale(new Product("kawa", 6));

$logger2 = function ($product) {
    print " logging ({$product->name}) <br>";
};

$processor = new ProcessSale();
$processor->registerCallback($logger2);
$processor->sale(new Product("buty", 6));
print "\n";
$processor->sale(new Product("kawa", 6));