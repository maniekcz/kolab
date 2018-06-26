<?php

namespace Tests\Kolab;

use PHPUnit\Framework\Assert;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;

class EventSourcingScenario
{
    /**
     * @var string
     */
    private $aggregateRootClass;

    /**
     * @var AggregateRoot
     */
    private $aggregateRoot;

    /**
     * @var Assert
     */
    private $assert;

    /**
     * EventSourcingScenario constructor.
     * @param string $aggregateRootClass
     */
    public function __construct($aggregateRootClass, Assert $assert)
    {
        $this->aggregateRootClass = $aggregateRootClass;
        $this->assert = $assert;
    }

    public function givenEvents(array $events)
    {
        $decorator = AggregateRootDecorator::newInstance();

        $this->aggregateRoot = $decorator->fromHistory($this->aggregateRootClass, new \ArrayIterator($events));

        return $this;
    }

    public function when(callable $callback)
    {
        $callback($this->aggregateRoot);

        return $this;
    }

    public function expectExactEvents(array $exepectedEvents)
    {
        $decorator = AggregateRootDecorator::newInstance();
        $recordedEvents = $decorator->extractRecordedEvents($this->aggregateRoot);

        $this->assert->assertEquals(count($exepectedEvents), count($recordedEvents));

        foreach ($exepectedEvents as $index => $exepectedEvent) {
            $this->assert->assertInstanceOf(get_class($exepectedEvent), $recordedEvents[$index]);
            $this->assert->assertEquals($exepectedEvent->payload(), $recordedEvents[$index]->payload());
        }

        return $this;
    }

    public function expectValue($expected, $actual)
    {
        $this->assert->assertEquals($expected, $actual);
    }

    /**
     * @return AggregateRoot
     */
    public function getAggregateRoot(): AggregateRoot
    {
        return $this->aggregateRoot;
    }
}