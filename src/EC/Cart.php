<?php

namespace EC;

use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $items = [];

    /**
     * @var UuidInterface
     */
    private $id;

    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function add(UuidInterface $productId, int $quantity = 1)
    {
        Assert::greaterThanEq($quantity, 1);

        if (!array_key_exists($productId->toString(), $this->items)) {
            $this->items[$productId->toString()] = new CartItem($productId, $quantity);
        } else {
            $currentQuantity = $this->items[$productId->toString()]->getQuantity();

            $this->items[$productId->toString()]->changeQuantity($currentQuantity + $quantity);
        }
    }

    public function remove(UuidInterface $productId)
    {
        if (!array_key_exists($productId->toString(), $this->items)) {
            throw new \LogicException("Invalid productId");
        }

        unset($this->items[$productId->toString()]);
    }

    public function changeQuantity(UuidInterface $productId, int $newQuantity)
    {
        Assert::greaterThanEq($newQuantity, 0);

        if (!array_key_exists($productId->toString(), $this->items)) {
            throw new \LogicException("Invalid productId");
        }

        if ($newQuantity == 0) {
            $this->remove($productId);
        } else {
            $this->items[$productId->toString()]->changeQuantity($newQuantity);
        }
    }

    public function clear()
    {
        $this->items = [];
    }

    /**
     * @return CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }
}