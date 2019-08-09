<?php

namespace EC\Repository;

use EC\Cart;
use EC\CartRepository;
use Gaufrette\Filesystem;
use Ramsey\Uuid\UuidInterface;

class FileCartRepository implements CartRepository
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * FileCartRepository constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getOrCreate(UuidInterface $cartId): Cart
    {
        if (!$this->filesystem->has('carts/' . $cartId->toString())) {
            return Cart::createFor($cartId);
        }

        return unserialize(
            $this->filesystem->read('carts/' . $cartId->toString())
        );
    }

    public function save(Cart $cart): void
    {
        foreach ($cart->fetchEvents() as $event) {
            $this->filesystem->write(
                'events/' . $cart->getId()->toString() . '_' . $event->getId()->toString(),
                serialize($event)
            );
        }

        $this->filesystem->write(
            'carts/' . $cart->getId()->toString(),
            serialize($cart),
            true
        );
    }
}