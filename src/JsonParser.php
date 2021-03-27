<?php

namespace App;

class JsonParser extends JsonExplorer
{
    protected $iterator;

    public function __construct()
    {
        parent::__construct();

        $this->iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($this->spec),
            \RecursiveIteratorIterator::SELF_FIRST
        );
    }

    public function getNamedNodes(): array
    {
        $namedNodes = [];

        foreach ($this->iterator as $node) {
            if (is_array($node) && array_key_exists('name', $node)) {
                $namedNodes[] = $node;
            }
        }

        return [
            'count' => count($namedNodes),
            'results' => $namedNodes
        ];
    }

    public function getNodeValues(string $name): array
    {
        $namedNodes = [];

        foreach ($this->iterator as $node) {
            if (is_array($node) && array_key_exists('name', $node)) {
                $isLeafNode = true;

                if ($node['name'] === $name) {
                    foreach ($node as $childNode) {
                        if (is_array($childNode)) {
                            $isLeafNode = false;
                        }
                    }

                    if ($isLeafNode) {
                        $namedNodes[] = $node;
                    }
                }
            }
        }

        return $namedNodes;
    }
}
