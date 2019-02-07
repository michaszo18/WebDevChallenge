<?php
class QueueElement
{
    private $_data;
    private $_next = null;

    public function __construct($data)
    {
        $this->_data = $data;
    } // end __construct();

    public function getData()
    {
        return $this->_data;
    } // end getData();

    public function setNext(QueueElement $next)
    {
        $this->_next = $next;
    } // end setNext();

    public function getNext()
    {
        return $this->_next;
    } // end getNext();
}


class Queue
{
    private $_first = null;
    private $_last = null;

    public function enqueue($data)
    {
      // Nic nie ma w kolejce.
        if ($this->_first === null) {
            $this->_first = $this->_last = new QueueElement($data);
        } else
      // Coś jest w kolejce, doklejamy się do ostatniego.
        {
            $element = new QueueElement($data);
            $this->_last->setNext($element);
            $this->_last = $element;
        }
    } // end enqueue();

    public function dequeue()
    {
        if ($this->_first === null) {
            throw new UnderflowException('Nie można pobrać elementu z pustej kolejki.');
        }
        $dequeued = $this->_first;
        $this->_first = $this->_first->getNext();

        if ($this->_first === null) {
            $this->_last = null;
        }

        return $dequeued->getData();
    } // end dequeue();

    public function __clone()
    {
      // Zalozmy, ze sklonowana kolejka jest pusta
        $top = $this->_first;
        $this->_first = $this->_last = null;

      // Przejedźmy się po dotychczasowej kolejce i skopiujmy
      // wszystkie jej elementy
        while ($top != null) {
            $this->enqueue($top->getData());
            $top = $top->getNext();
        }
    } // end __clone();
}

$queue = new Queue;
$queue->enqueue(5);
$queue->enqueue(4);
$queue->enqueue(3);
$queue->enqueue(5);
$queue->enqueue(1);

$cloned = clone $queue;
$cloned->enqueue(2);

try {
    while (true) {
        echo $queue->dequeue() . '<br/>';
    }
} catch (UnderflowException $exception) {
   // pusto
}