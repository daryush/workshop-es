<?php

namespace EC;

use EC\Events\CartCleared;
use EC\Events\CartCreated;
use EC\Events\Event;
use EC\Events\ProductAddedToCart;
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

    /**
     * @var int
     */
    private $version = 1;

    /**
     * @var Event[]
     */
    private $events = [];

    private function __construct()
    {
    }

    public static function createFor(UuidInterface $id)
    {
        $cart = new self();

        $cart->recordThat(new CartCreated($id));

        return $cart;
    }

    public static function fromHistory(array $events)
    {
        $object = new self();

        foreach ($events as $event) {
            $object->apply($event);
            $object->version = $event->getVersion();
        }

        return $object;
    }

    public function add(UuidInterface $productId, int $quantity = 1)
    {
        Assert::greaterThanEq($quantity, 1);

        $this->recordThat(new ProductAddedToCart($this->id, $productId, $quantity));
    }

    protected function recordThat(Event $event)
    {
        $event->setVersion($this->version++);

        $this->events[] = $event;

        $this->apply($event);
    }

    protected function apply(Event $event)
    {
        switch (get_class($event)) {
            case CartCreated::class:
                /** @var $event CartCreated */
                $this->id = $event->getCartId();

                break;
            case ProductAddedToCart::class:
                /** @var $event ProductAddedToCart */
                if (!array_key_exists($event->getProductId()->toString(), $this->items)) {
                    $this->items[$event->getProductId()->toString()] = new CartItem($event->getProductId(), $event->getQuantity());
                } else {
                    $currentQuantity = $this->items[$event->getProductId()->toString()]->getQuantity();

                    $this->items[$event->getProductId()->toString()]->changeQuantity($currentQuantity + $event->getQuantity());
                }

                break;
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
        $this->events[] = new CartCleared($this->id);
    }

    public function fetchEvents(): array
    {
        $events = $this->events;

        $this->events = [];

        return $events;
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