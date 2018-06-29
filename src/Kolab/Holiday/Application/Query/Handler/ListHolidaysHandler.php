<?php

namespace Kolab\Holiday\Application\Query\Handler;

use Kolab\Holiday\Application\Query\ListHolidays;
use Kolab\Holiday\Infrastructure\Projection\HolidaysFinder;
use React\Promise\Deferred;


class ListHolidaysHandler
{
    /**
     * @var HolidaysFinder
     */
    private $finder;

    /**
     * ListHolidaysHandler constructor.
     * @param HolidaysFinder $finder
     */
    public function __construct(HolidaysFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(ListHolidays $query, Deferred $deferred)
    {

        $holidays = $this->finder->findAllPaginated(
            $query->limit()
        );
        $counter = $this->finder->countAll();
        $results = [
            'holidays' => $holidays,
            'total' => $counter
        ];
        if (null === $deferred) {
            return $results;
        }
        $deferred->resolve($results);
    }
}