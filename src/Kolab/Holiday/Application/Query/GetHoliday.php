<?php
namespace Kolab\Holiday\Application\Query;

use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class GetHoliday extends Query
{
    use PayloadTrait;

    /**
     * @param string $holidayId
     * @return GetHoliday
     */
    public static function withId(string $holidayId)
    {
        return new self([
            'holidayId' => $holidayId,
        ]);
    }

    public function holidayId(): string
    {
        return $this->payload['holidayId'];
    }
}