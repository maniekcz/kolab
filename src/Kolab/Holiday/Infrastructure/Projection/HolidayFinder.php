<?php

namespace Kolab\Holiday\Infrastructure\Projection;

use Doctrine\DBAL\Connection;
use Kolab\Holiday\Domain\HolidayState;

class HolidayFinder implements HolidaysFinder
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * HolidayFinder constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(string $cycleId)
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s WHERE id = :id AND state != :state', Table::READ_HOLIDAY));
        $stmt->bindValue('id', $cycleId);
        $stmt->bindValue('state', HolidayState::DELETED);
        $stmt->execute();
        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return HolidayRead::setFromArray($result);
    }

    public function findAllPaginated($limit)
    {
        $stmt = $this->connection->prepare(
            '
          SELECT * FROM ' . Table::READ_HOLIDAY . '
          WHERE state != :deleted
          LIMIT :limit'
        );
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':deleted', HolidayState::DELETED, \PDO::PARAM_STR);

        $stmt->execute();

        $holidays = $stmt->fetchAll();

        if (false === $holidays) {
            return null;
        }

        return array_map(function ($holiday) {
            return HolidayRead::setFromArray($holiday);
        }, $holidays);
    }

    public function countAll()
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM ' . Table::READ_HOLIDAY . '
          WHERE state != :deleted'
        );

        $stmt->bindValue(':deleted', HolidayState::DELETED);
        $stmt->execute();

        return $stmt->rowCount();
    }

}