<?php

declare(strict_types=1);

namespace Kolab\Holiday\Domain;


use DateTime;
use Kolab\BaseAggregateRoot;
use Kolab\Holiday\Domain\Event\HolidayCreated;
use Kolab\Holiday\Domain\Event\HolidayApproved;

final class Holiday extends BaseAggregateRoot
{
    /**
     * @var HolidayId $holidayId
     */
    private $holidayId;

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var HolidayState
     */
    private $state;

    protected function aggregateId(): string
    {
        return $this->holidayId()->toString();
    }

    public function holidayId(): HolidayId
    {
        return $this->holidayId;
    }

    public function state(): HolidayState
    {
        return $this->state;
    }

    public static function create(HolidayId $holidayId, DateTime $start): Holiday
    {
        $self = new self();

        $self->recordThat(HolidayCreated::withData(
            $holidayId,
            HolidayState::NEW(),
            $start
        ));

        return $self;
    }

    public function approve(): void
    {
        $this->recordThat(HolidayApproved::withData(
            $this->holidayId(),
            HolidayState::APPROVED()
        ));
    }

    public function whenHolidayCreated(HolidayCreated $event): void
    {
        $this->holidayId = $event->holidayId();
        $this->state = $event->state();
        $this->start = $event->start();
    }

    public function whenHolidayApproved(HolidayApproved $event): void
    {
        $this->state = $event->state();
    }


}
