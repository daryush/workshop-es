<?php

namespace EC\Handler;

use EC\CartRepository;
use EC\Command\AddProductToCart;
use EC\Command\ClearCart;
use Ramsey\Uuid\Uuid;

class ClearCartHandler
{
    /**
     * @var CartRepository
     */
    private $carts;

    /**
     * AddProductToCartHandler constructor.
     * @param CartRepository $carts
     */
    public function __construct(CartRepository $carts)
    {
        $this->carts = $carts;
    }

    public function __invoke(ClearCart $command)
    {
        $cart = $this->carts->getOrCreate($command->getCartId());

        $cart->clear();

        $this->carts->save($cart);
    }
}