<?php

declare(strict_types=1);

namespace Kolab\Holiday\Domain\ProcessManager;

use Kolab\Holiday\Domain\Event\HolidayApproved;
use Prooph\ServiceBus\CommandBus;

class SendConfirmationProcessManager
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(HolidayApproved $event): void
    {
        //$this->commandBus->dispatch();
    }
}