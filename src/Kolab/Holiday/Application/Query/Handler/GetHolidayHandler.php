<?php

namespace Kolab\Holiday\Application\Query\Handler;

use Kolab\Holiday\Application\Query\GetHoliday;
use Kolab\Holiday\Infrastructure\Projection\HolidaysFinder;
use React\Promise\Deferred;

class GetHolidayHandler
{
    /**
     * @var HolidaysFinder
     */
    private $finder;

    /**
     * GetHolidayHandler constructor.
     * @param HolidaysFinder $finder
     */
    public function __construct(HolidaysFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(GetHoliday $query, Deferred $deferred)
    {
        $holiday = $this->finder->findById($query->holidayId());
        if (null === $deferred) {
            return $holiday;
        }
        $deferred->resolve($holiday);
    }
}