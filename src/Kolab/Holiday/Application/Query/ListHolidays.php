<?php
namespace Kolab\Holiday\Application\Query;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

class ListHolidays extends Query
{
    use PayloadTrait;

    /**
     * @param int $limit
     * @return ListHolidays
     */
    public static function withData(int $limit)
    {
        return new self([
            'limit' => $limit,
        ]);
    }
    public function limit(): int
    {
        return $this->payload['limit'];
    }
}