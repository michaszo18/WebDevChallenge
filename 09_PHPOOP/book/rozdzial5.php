<?php
const BR = "<br>";

class StaticExample {
    static public $aNum = 0;
    static public function sayHello() {
        print "Hello, (" . self::$aNum . ")".BR;
    }
}

print StaticExample::$aNum;
StaticExample::sayHello();