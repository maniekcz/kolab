<?php

namespace Kolab\Holiday\Infrastructure\Projection;



use DateTime;
use Kolab\Customer\Domain\CustomerId;
use Kolab\Holiday\Domain\HolidayId;
use Kolab\Holiday\Domain\HolidayState;

class HolidayRead
{
    /**
     * @var HolidayId
     */
    private $holidayId;

    /**
     * @var CustomerId
     */
    private $customerId;

    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var HolidayState
     */
    private $state;

    /**
     * HolidayRead constructor.
     * @param HolidayId $holidayId
     * @param CustomerId $customerId
     * @param DateTime $start
     * @param HolidayState $state
     */
    public function __construct(
        HolidayId $holidayId,
        CustomerId $customerId,
        DateTime $start,
        HolidayState $state
    ) {
        $this->holidayId = $holidayId;
        $this->customerId = $customerId;
        $this->start = $start;
        $this->state = $state;
    }

    /**
     * @param array $data
     * @return HolidayRead
     */
    public static function setFromArray(array $data): HolidayRead
    {
        return new self(
            HolidayId::fromString($data['id']),
            CustomerId::fromString($data['customer_id']),
            new DateTime($data['start']),
            HolidayState::byName($data['state'])
        );
    }

    public function customerId(): CustomerId
    {
        return $this->customerId;
    }
}
