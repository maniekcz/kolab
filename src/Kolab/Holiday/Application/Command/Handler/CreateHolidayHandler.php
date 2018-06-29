<?php

namespace Kolab\Holiday\Application\Command\Handler;

use Kolab\Holiday\Application\Command\CreateHoliday;
use Kolab\Holiday\Domain\Holiday;
use Kolab\Holiday\Domain\Holidays;

final class CreateHolidayHandler
{
    /**
     * @var Holidays
     */
    protected $holidays;

    /**
     * CreateHolidayHandler constructor.
     * @param Holidays $holidays
     */
    public function __construct(Holidays $holidays)
    {
        $this->holidays = $holidays;
    }

    public function __invoke(CreateHoliday $command)
    {
        $holiday = Holiday::create(
            $command->holidayId(),
            $command->customerId(),
            $command->start()
        );
        $this->holidays->save($holiday);
    }
}