<?php

namespace App;

class Product
{
    public function __construct(public string $name, public int $price)
    {
    }

    public function getInfo(): string
    {
        return "$this->name: {$this->getHumanPrice()}";
    }

    public function getHumanPrice(): float
    {
        return $this->price / 100;
    }
}