<?php

namespace Kolab\Holiday\Domain\Event;

use DateTime;
use Kolab\Holiday\Domain\HolidayId;
use Kolab\Holiday\Domain\HolidayState;
use Prooph\EventSourcing\AggregateChanged;

class HolidayApproved extends AggregateChanged
{
    /**
     * @var HolidayId
     */
    private $holidayId;

    /**
     * @var HolidayState
     */
    private $state;

    public static function withData(HolidayId $holidayId, HolidayState $state): HolidayApproved
    {
        /** @var self $event */
        $event = self::occur($holidayId->toString(), [
            'state' => $state
        ]);
        $event->holidayId = $holidayId;
        $event->state = $state;

        return $event;
    }

    public function holidayId(): HolidayId
    {
        if (! $this->holidayId) {
            $this->holidayId = HolidayId::fromString($this->aggregateId());
        }
        return $this->holidayId;
    }

    public function state(): HolidayState
    {
        if (! $this->state) {
            $this->state = HolidayState::byName($this->payload['state']);
        }
        return $this->state;
    }

}