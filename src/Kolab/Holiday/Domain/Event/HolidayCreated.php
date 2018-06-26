<?php

namespace Kolab\Holiday\Domain\Event;

use DateTime;
use Kolab\Holiday\Domain\Holiday;
use Kolab\Holiday\Domain\HolidayId;
use Kolab\Holiday\Domain\HolidayState;
use Prooph\EventSourcing\AggregateChanged;

class HolidayCreated extends AggregateChanged
{
    /**
     * @var HolidayId
     */
    private $holidayId;

    /**
     * @var HolidayState
     */
    private $state;

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @param HolidayId $holidayId
     * @param HolidayState $state
     * @param DateTime $start
     * @return HolidayCreated
     */
    public static function withData(HolidayId $holidayId, HolidayState $state, DateTime $start): HolidayCreated
    {
        /** @var self $event */
        $event = self::occur($holidayId->toString(), [
            'state' => $state->toString(),
            'start' => $start->format('YY-mm-dd')
        ]);

        $event->holidayId = $holidayId;
        $event->state = $state;

        return $event;
    }

    /**
     * @return HolidayId
     */
    public function holidayId(): HolidayId
    {
        if (! $this->holidayId) {
            $this->holidayId = HolidayId::fromString($this->aggregateId());
        }
        return $this->holidayId;
    }

    /**
     * @return HolidayState
     */
    public function state(): HolidayState
    {
        if (! $this->state) {
            $this->state = HolidayState::byName($this->payload['state']);
        }
        return $this->state;
    }

    /**
     * @return DateTime
     */
    public function start(): DateTime
    {
        if (! $this->start) {
            $this->start = New DateTime($this->payload['start']);
        }
        return $this->start;
    }


}