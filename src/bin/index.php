<?php

use App\Vending;
use App\VendingDisplay;
use App\Product;

require __DIR__ . "/../src/Vending.php";
require __DIR__ . "/../src/VendingDisplay.php";
require __DIR__ . "/../src/Product.php";

$display = new VendingDisplay();
$vending = new Vending($display);
$vending->addProduct(new Product("Coca-cola", 150))
    ->addProduct(new Product("Snickers", 120))
    ->addProduct(new Product("Lay's", 200));

$display->displayMessage("Hello, here is list of products:");

foreach ($vending->getProducts() as $key => $product) {
    $display->displayMessage($key . ": " . $product->getInfo());
}

$selectedProduct = false;
while (!$selectedProduct) {
    $chosenId = intval(readline("Chose product" . PHP_EOL));
    $selectedProduct = $vending->getProductById($chosenId);

    if($selectedProduct) {
        break;
    }

    $display->displayMessage("Product is not chosen");
}

while (!$vending->canBuy($selectedProduct)) {
    $display->displayMessage("Not enough balance. You have {$vending->getHumanBalance()}");
    $coin = floatval(readline("Select Coin" . PHP_EOL));
    $vending->addCoins($coin * 100);
}

$display->displayMessage("Here is your product:");

$vending->purchase($selectedProduct);

$vending->returnChange(function ($coin, $coinsCount) use ($display) {
    $display->displayMessage("$coin: $coinsCount");
});