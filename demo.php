<?php

use EC\Cart;
use EC\Command\AddProductToCart;
use EC\Command\ClearCart;
use EC\Handler\AddProductToCartHandler;
use EC\Handler\ClearCartHandler;
use EC\Product;
use EC\Repository\FileCartRepository;
use EC\Repository\InMemoryCartsRepository;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

require __DIR__ . '/vendor/autoload.php';

//$carts = new InMemoryCartsRepository();
$adapter = new Local('var/');
//$adapter = new \Gaufrette\Adapter\Zip('var/carts.zip');
$carts = new \EC\Repository\InMemoryEventSourcedCartsRepository();
$cartId = Uuid::uuid4();
$laptop = new Product(Uuid::uuid4(), 'Laptop');
$pecet = new Product(Uuid::uuid4(), 'Pecet');

$bus = new MessageBus([
    new HandleMessageMiddleware(new HandlersLocator([
        AddProductToCart::class => [new AddProductToCartHandler($carts)],
        ClearCart::class => [new ClearCartHandler($carts)],
    ])),
]);

$bus->dispatch(new AddProductToCart($cartId->toString(), $laptop->getId()->toString()));
$bus->dispatch(new AddProductToCart($cartId->toString(), $laptop->getId()->toString()));
$bus->dispatch(new AddProductToCart($cartId->toString(), $pecet->getId()->toString()));
$bus->dispatch(new ClearCart($cartId->toString()));

//current($cart->getItems())->changeQuantity(-10); // @todo To jest problem -> clone na zwrotce z metody

$cart = $carts->getOrCreate($cartId);

dump($cart);
