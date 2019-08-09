<?php

use EC\Cart;
use EC\Product;
use EC\Repository\InMemoryCartsRepository;
use Ramsey\Uuid\Uuid;

require __DIR__ . '/vendor/autoload.php';

$carts = new InMemoryCartsRepository();
$cart = new Cart(Uuid::uuid4());
$laptop = new Product(Uuid::uuid4(), 'Laptop');

$cart->add($laptop->getId());
$cart->add($laptop->getId());
$cart->add($laptop->getId());

//current($cart->getItems())->changeQuantity(-10); // @todo To jest problem -> clone na zwrotce z metody

$carts->save($cart);

dump($carts);