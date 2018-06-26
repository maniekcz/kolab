<?php

namespace Kolab\Holiday\Domain;

interface Holidays
{
    public function get(HolidayId $holidayId);

    public function save(Holiday $holiday): void;
}