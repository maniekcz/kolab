<?php

namespace Kolab\Holiday\Application\Command;

use Kolab\Holiday\Domain\HolidayId;
use \DateTime;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class CreateHoliday extends Command implements PayloadConstructable
{
    use PayloadTrait;

    /**
     * @param string $holidayId
     * @param string $start
     * @return CreateHoliday
     */
    public static function withData(string $holidayId, string $start): CreateHoliday
    {
        return new self(
            [
                'holidayId' => $holidayId,
                'start' => $start
            ]
        );
    }

    public function holidayId(): HolidayId
    {
        return HolidayId::fromString($this->payload['holidayId']);
    }

    public function start(): DateTime
    {
        return new DateTime($this->payload['start']);
    }
}