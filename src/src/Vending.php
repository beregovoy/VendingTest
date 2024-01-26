<?php

namespace App;

class Vending
{
    protected int $balance = 0;

    /**
     * @var Product[] $products
     */
    protected array $products = [];

    const COINS = [100, 50, 25, 10, 5, 1];
    public function __construct(protected VendingDisplay $display)
    {
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        $this->products[] = $product;
        return $this;
    }

    public function getProductById($id): ?Product
    {
        return $this->products[$id] ?? null;
    }

    public function getHumanBalance(): float
    {
        return $this->balance / 100;
    }

    public function addCoins(int $coins): void
    {
        $this->balance+=$coins;
    }

    public function canBuy(Product $product): bool
    {
        return $this->balance >= $product->price;
    }

    public function purchase(Product $product): void
    {
        $this->balance -= $product->price;
        $this->display->displayMessage("$product->name for {$product->getHumanPrice()}. Your balance now {$this->getHumanBalance()}");
    }

    public function returnChange(?callable $callback = null): void
    {
        foreach(static::COINS as $coin) {
            $numOfCoins = floor($this->balance / $coin);

            if(is_callable($callback)) {
                $callback($coin, $numOfCoins);
            }

            $this->balance -= $coin*$numOfCoins;
        }
    }
}