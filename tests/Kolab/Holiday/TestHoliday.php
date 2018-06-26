<?php
namespace Tests\Kolab\Holiday;

use Kolab\Holiday\Domain\Event\HolidayApproved;
use Kolab\Holiday\Domain\Event\HolidayCreated;
use Kolab\Holiday\Domain\Holiday;
use Kolab\Holiday\Domain\HolidayId;
use Kolab\Holiday\Domain\HolidayState;
use PHPUnit\Framework\TestCase;
use Tests\Kolab\EventSourcingScenario;

class HolidayTest extends TestCase
{
    public function testApproveHoliday()
    {
        $scenario = new EventSourcingScenario(Holiday::class, $this);

        $holidayId = HolidayId::generate();

        $scenario
            ->givenEvents([
                HolidayCreated::withData($holidayId, HolidayState::NEW(), new \DateTime('2017-12-12'))
            ])
            ->when(function (Holiday $holiday) {
                $holiday->approve();
            })
            ->expectExactEvents([
                HolidayApproved::withData(
                    $holidayId,
                    HolidayState::APPROVED()
                ),
            ])
            ->expectValue(HolidayState::APPROVED(), $scenario->getAggregateRoot()->state());
    }



}