<?php

namespace Kolab\Holiday\Infrastructure\Projection;

use Doctrine\DBAL\Connection;
use Kolab\Holiday\Domain\Event\HolidayCreated;
use Prooph\EventStore\Projection\ProjectionManager;
use Kolab\Model\Projections;

class HolidayProjectionRunner implements Projections
{
    /**
     * @var ProjectionManager
     */
    private $projectionManager;

    /**
     * @var Connection
     */
    private $pdo;

    public function __construct(ProjectionManager $projectionManager, Connection $pdo)
    {
        $this->projectionManager = $projectionManager;
        $this->pdo = $pdo;
    }

    public function __invoke(bool $keepRunning = true)
    {
        $pdo = $this->pdo;

        $this->projectionManager
            ->createProjection('holiday')
            ->fromAll()
            ->when([
                HolidayCreated::class => function (array $state, HolidayCreated $event) use ($pdo) {
                    $pdo->insert(Table::READ_HOLIDAY, [
                        'id' => $event->holidayId()->toString(),
                        'customer_id' => $event->customerId()->toString(),
                        'start' => $event->start()->format('Y-m-d H:i:s'),
                        'created' => $event->createdAt()->format('Y-m-d H:i:s'),
                        'updated' => $event->createdAt()->format('Y-m-d H:i:s'),
                        'state' => $event->state()->toString()
                    ]);
                },
            ])
            ->run($keepRunning);
    }
}