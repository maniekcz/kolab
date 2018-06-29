<?php

declare(strict_types=1);

namespace Kolab\Customer\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CustomerId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): CustomerId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $customerId): CustomerId
    {
        return new self(Uuid::fromString($customerId));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString()
    {
        return $this->uuid->toString();
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(CustomerId $other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}