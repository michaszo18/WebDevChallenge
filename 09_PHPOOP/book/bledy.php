<?php

class Conf
{
    private $file;
    private $xml;
    private $lastmatch;

    public function __construct($file)
    {
        $this->file = $file;
        if (!file_exists($file)) {
            throw new Exception("plik '$file' nie istnieje");
        }
        $this->xml = simplexml_load_file($file, null, LIBXML_NOERROR);

        if (!is_object($this->xml)) {
            throw new XmlException((libxml_get_last_error()));
        }

        echo gettype($this->xml);
        $matches = $this->xml->xpath("/conf");
        if (!count($matches)) {
            throw new ConfException("nie można odnaleźć elementu: conf");
        }

    }

    public function write()
    {
        if (!is_writable($this->file)) {
            throw new Exception("plik '{$this->file}' nie da się zapisiać");
        }
        file_put_contents($this->file, $this->xml->asXML());
    }

    public function get($str)
    {
        $matches = $this->xml->xpath("/conf/item[@name=\"$str\"]");

        if (count($matches)) {
            $this->lastmatch = $matches[0];
            return (string)$matches[0];
        }

        return null;
    }

    public function set($key, $value)
    {
        if (!is_null($this->get($key))) {
            $this->lastmatch[0] = $value;
            return;
        }

        $conf = $this->xml->conf;
        $this->xml->addChild('item', $value)->addAttribute('name', $key);
    }
}

// try {
//     $conf = new Conf(dirname(__FILE__)."\conf01.xml");
//     echo "user: " . $conf->get('user') . "<br>";
//     echo "host: " . $conf->get('host') . "<br>";
//     $conf->set("pass", "newpass");
//     $conf->write();
// } catch (Exception $e) {
//     die($e->__toString());
// }

class XmlException extends Exception
{
    private $error;
    function __construct(LibXmlError $error)
    {
        $shortfile = basename($error->file);
        $msg = "[{$shortfile}, wiersz {$error->line}, " .
            "kolumna {$error->column}] {$error->message}";
        $this->error = $error;
        parent::__construct($msg, $error->code);
    }
    function getLibXmlError()
    {
        return $this->error;
    }
}

class FileException extends Exception
{
}
class ConfException extends Exception
{
}

class Runner
{

    static function init()
    {
        $fh = fopen("./log.txt", "w");
        try {
            fputs($fh, "start\n");
            $conf = new Conf(dirname(__FILE__) . "/conf01.xml");
            print "user: " . $conf->get('user') . "\n";
            print "host: " . $conf->get('host') . "\n";
            $conf->set("pass", "newpass");
            $conf->write();
        } catch (FileException $e) {
            // problem uprawnień albo braku pliku
            fputs($fh, "file exception\n");
            throw $e;
        } catch (XmlException $e) {
            fputs($fh, "xml exception\n");
            // niepoprawny xml
        } catch (ConfException $e) {
            fputs($fh, "conf exception\n");
            // niewłaściwy plik XML
        } catch (Exception $e) {
            fputs($fh, "general exception\n");
            // inny błąd: nie powinno się to zdarzyć
        }
        finally {
            fputs($fh, "end\n");
            fclose($fh);
        }
    }
}

Runner::init();