<?php

namespace EC;

use Ramsey\Uuid\Uuid;

class CartService
{
    /**
     * @var CartRepository
     */
    private $carts;

    /**
     * CartService constructor.
     * @param CartRepository $carts
     */
    public function __construct(CartRepository $carts)
    {
        $this->carts = $carts;
    }

    public function addProduct(string $cartId, string $productId, int $quantity= 1)
    {
        $cart = $this->carts->getOrCreate(Uuid::fromString($cartId));

        $cart->add(Uuid::fromString($productId), $quantity);

        $this->carts->save($cart);
    }

    public function removeProduct(string $cartId, string $productId)
    {
        $cart = $this->carts->getOrCreate(Uuid::fromString($cartId));

        $cart->remove(Uuid::fromString($productId));

        $this->carts->save($cart);
    }
}