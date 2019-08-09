<?php

namespace EC\Handler;

use EC\CartRepository;
use EC\Command\AddProductToCart;
use Ramsey\Uuid\Uuid;

class AddProductToCartHandler
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

    public function __invoke(AddProductToCart $command)
    {
        $cart = $this->carts->getOrCreate($command->getCartId());

        $cart->add($command->getProductId(), $command->getQuantity());

        $this->carts->save($cart);
    }
}