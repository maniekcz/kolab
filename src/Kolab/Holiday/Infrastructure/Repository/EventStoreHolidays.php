<?php
declare(strict_types=1);
namespace Kolab\Holiday\Infrastructure\Repository;

use Kolab\Holiday\Domain\Holidays;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Kolab\Holiday\Domain\Holiday;
use Kolab\Holiday\Domain\HolidayId;

final class EventStoreHolidays extends AggregateRepository implements Holidays
{
    public function save(Holiday $holiday): void
    {
        $this->saveAggregateRoot($holiday);
    }
    public function get(HolidayId $holidayId):? Holiday
    {
        return $this->getAggregateRoot($holidayId->toString());
    }
}