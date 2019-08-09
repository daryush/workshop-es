<?php

namespace EC;

use Ramsey\Uuid\UuidInterface;

class CartItem
{
    /**
     * @var UuidInterface
     */
    private $productId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * CartItem constructor.
     * @param UuidInterface $productId
     * @param int $quantity
     */
    public function __construct(UuidInterface $productId, $quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    /**
     * @return UuidInterface
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function changeQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }
}