<?php


namespace EC;

use Ramsey\Uuid\UuidInterface;

class Product
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Product constructor.
     * @param UuidInterface $id
     * @param string $name
     */
    public function __construct(UuidInterface $id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}