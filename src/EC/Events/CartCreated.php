<?php

namespace EC\Events;

use Ramsey\Uuid\UuidInterface;

class CartCreated extends Event
{
    /**
     * @var UuidInterface
     */
    private $cartId;

    /**
     *  constructor.
     * @param UuidInterface $cartId
     */
    public function __construct(UuidInterface $cartId)
    {
        parent::__construct();

        $this->cartId = $cartId;
    }

    /**
     * @return UuidInterface
     */
    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }
}