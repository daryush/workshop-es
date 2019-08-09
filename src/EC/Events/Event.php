<?php

namespace EC\Events;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class Event
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @var int
     */
    private $version;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->created = new \DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }
}