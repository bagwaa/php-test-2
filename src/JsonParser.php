<?php

namespace App;

class JsonParser extends JsonExplorer
{
    protected $namedNodes = [];

    public function getNamedNodes(): array
    {
        $recursiveIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($this->spec),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $namedNodes = [];

        foreach ($recursiveIterator as $key => $value) {
            if (is_array($value) && array_key_exists('name', $value)) {
                $namedNodes[] = $value;
            }
        }

        return [
            'count' => count($namedNodes),
            'results' => $namedNodes
        ];
    }

    public function getNodeValues(string $name): array
    {
        $recursiveIterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($this->spec),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $namedNodes = [];

        foreach ($recursiveIterator as $key => $value) {
            if (is_array($value) && array_key_exists('name', $value)) {
                $arrayFound = false;

                if ($value['name'] === $name) {
                    foreach ($value as $subNode) {
                        if (is_array($subNode)) {
                            $arrayFound = true;
                        }
                    }

                    if (!$arrayFound) {
                        $namedNodes[] = $value;
                    }
                }
            }
        }

        return $namedNodes;
    }
}
