<?php

namespace App;

class VendingDisplay
{
    public function displayMessage(string $message): void
    {
        echo $message . PHP_EOL;
    }
}