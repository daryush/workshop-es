<?php

namespace EC\Repository;

use EC\Cart;
use EC\CartRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class InMemoryCartsRepository implements CartRepository
{
    /**
     * @var Cart[]
     */
    private $carts = [];

    public function getOrCreate(UuidInterface $cartId): Cart
    {
        if (!array_key_exists($cartId->toString(), $this->carts)) {
            $cart = new Cart($cartId);
            $cartId = $cart->getId();

            $this->carts[$cartId->toString()] = $cart;
        }

        return $this->carts[$cartId->toString()];
    }

    public function save(Cart $cart): void
    {
        $this->carts[$cart->getId()->toString()] = $cart;
    }
}