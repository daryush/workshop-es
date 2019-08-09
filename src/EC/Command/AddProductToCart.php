<?php

namespace EC\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AddProductToCart
{
    /**
     * @var string
     */
    private $cartId;

    /**
     * @var string
     */
    private $productId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * AddProductToCart constructor.
     * @param string $cartId
     * @param string $productId
     * @param int $quantity
     */
    public function __construct(string $cartId, string $productId, int $quantity = 1)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @return UuidInterface
     */
    public function getCartId(): UuidInterface
    {
        return Uuid::fromString($this->cartId);
    }

    /**
     * @return UuidInterface
     */
    public function getProductId(): UuidInterface
    {
        return Uuid::fromString($this->productId);
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}