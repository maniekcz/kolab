<?php

namespace RST\Invitation\Infrastructure\Projection;

use Doctrine\DBAL\Connection;
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
                InvitationWasCreated::class => function (array $state, InvitationWasCreated $event) use ($pdo) {
                    $pdo->insert(Table::READ_INVITATION, [
                        'id' => (string) $event->aggregateId(),
                        'cycle_id' => (string) $event->cycleId(),
                        'tester_id' => (string) $event->testerId(),
                        'title' => (string) $event->title(),
                        'message' => (string) $event->message(),
                        'created' => $event->createdAt()->format('Y-m-d H:i:s'),
                        'updated' => $event->createdAt()->format('Y-m-d H:i:s'),
                        'state' => (string) $event->state()
                    ]);
                },
            ])
            ->run($keepRunning);
    }
}