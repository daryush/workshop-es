<?php

namespace EC\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ClearCart
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * AddProductToCart constructor.
     * @param string $cartId
     * @param string $productId
     * @param int $quantity
     */
    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @return UuidInterface
     */
    public function getCartId(): UuidInterface
    {
        return Uuid::fromString($this->cartId);
    }
}