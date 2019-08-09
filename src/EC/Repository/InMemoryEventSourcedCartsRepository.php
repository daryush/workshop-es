<?php

namespace EC\Repository;

use EC\Cart;
use EC\CartRepository;
use EC\Events\Event;
use Ramsey\Uuid\UuidInterface;

class InMemoryEventSourcedCartsRepository implements CartRepository
{
    private $events = [];

    public function getOrCreate(UuidInterface $cartId): Cart
    {
        if (!array_key_exists($cartId->toString(), $this->events)) {
            return Cart::createFor($cartId);
        }

        return Cart::fromHistory(
            $this->events[$cartId->toString()]
        );
    }

    public function save(Cart $cart): void
    {
        /** @var Event $event */
        foreach ($cart->fetchEvents() as $event) {
            $this->events[$cart->getId()->toString()][$event->getVersion()] = $event;
        }
    }
}
