<?php

declare(strict_types=1);

namespace Kolab\Holiday\Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class HolidayId
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): HolidayId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $holidayId): HolidayId
    {
        return new self(Uuid::fromString($holidayId));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(HolidayId $other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}