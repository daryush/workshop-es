<?php

namespace EC\Events;

use Ramsey\Uuid\UuidInterface;

class ProductAddedToCart extends Event
{
    /**
     * @var UuidInterface
     */
    private $cartId;

    /**
     * @var UuidInterface
     */
    private $productId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * ProductAddedToCart constructor.
     * @param UuidInterface $cartId
     * @param UuidInterface $productId
     * @param int $quantity
     */
    public function __construct(UuidInterface $cartId, UuidInterface $productId, int $quantity)
    {
        parent::__construct();

        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @return UuidInterface
     */
    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    /**
     * @return UuidInterface
     */
    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}