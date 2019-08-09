<?php

namespace EC;

use Ramsey\Uuid\UuidInterface;

interface CartRepository
{
    public function getOrCreate(UuidInterface $cartId): Cart;

    public function save(Cart $cart): void;
}