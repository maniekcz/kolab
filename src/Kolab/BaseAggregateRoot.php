<?php

declare(strict_types=1);
namespace Kolab;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

abstract class BaseAggregateRoot extends AggregateRoot
{
    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);
        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }
        $this->{$handler}($event);
    }
    protected function determineEventHandlerMethodFor(AggregateChanged $event)
    {
        return 'when' . implode(array_slice(explode('\\', get_class($event)), -1));
    }
}