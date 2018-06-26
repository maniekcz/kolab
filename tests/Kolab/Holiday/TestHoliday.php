<?php
namespace Tests\Kolab\Holiday;

use Kolab\Holiday\Domain\Event\HolidayCreated;
use Kolab\Holiday\Domain\Holiday;
use PHPUnit\Framework\TestCase;
use Tests\Kolab\EventSourcingScenario;

class CycleTest extends TestCase
{
    public function testCreateMobileEnv()
    {
        $scenario = new EventSourcingScenario(Holiday::class, $this);

        $scenario
            ->givenEvents([
                HolidayCreated::withData($cycleId)
            ])
            ->when(function (Holiday $holiday) {
                $cycle->createEnvironment($environmentData);
            })
            ->expectExactEvents([
                MobileEnvironmentCreated::withData(
                    $cycleId,
                    $environmentData['type'],
                    $environmentData['dimension'],
                    $environmentData['links'],
                    $environmentData['systems'],
                    $environmentData['devices']
                ),
            ])
            ->expectValue(Dimension::SYSTEMS, $scenario->getAggregateRoot()->environment()->dimension());
    }



}