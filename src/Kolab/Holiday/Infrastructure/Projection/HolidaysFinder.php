<?php

namespace Kolab\Holiday\Infrastructure\Projection;

interface HolidaysFinder
{
    public function findById(string $holidayId);
    public function findAllPaginated($limit);
    public function countAll();
}