<?php

namespace App;

abstract class JsonExplorer
{
    protected $spec;
    public function __construct()
    {
        // downloads a json text file and decodes it into a associative array
        $this->spec = json_decode(file_get_contents("https://pastebin.com/raw/5jts6bqd"));
    }

    abstract public function getNamedNodes() : array;
    abstract public function getNodeValues(string $name) : array;
}
