<?php

use EC\Cart;
use EC\Command\AddProductToCart;
use EC\Command\ClearCart;
use EC\Handler\AddProductToCartHandler;
use EC\Handler\ClearCartHandler;
use EC\Product;
use EC\Repository\InMemoryCartsRepository;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

require __DIR__ . '/vendor/autoload.php';

$carts = new InMemoryCartsRepository();
$cart = new Cart(Uuid::uuid4());
$laptop = new Product(Uuid::uuid4(), 'Laptop');

$bus = new MessageBus([
    new HandleMessageMiddleware(new HandlersLocator([
        AddProductToCart::class => [new AddProductToCartHandler($carts)],
        ClearCart::class => [new ClearCartHandler($carts)],
    ])),
]);

$bus->dispatch(new AddProductToCart($cart->getId()->toString(), $laptop->getId()->toString()));
$bus->dispatch(new AddProductToCart($cart->getId()->toString(), $laptop->getId()->toString()));
//$bus->dispatch(new ClearCart($cart->getId()->toString()));

//current($cart->getItems())->changeQuantity(-10); // @todo To jest problem -> clone na zwrotce z metody

dump($carts);