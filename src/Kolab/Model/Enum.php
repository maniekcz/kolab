<?php

namespace Kolab\Model;

use MyCLabs\Enum\Enum as EnumClabs;

abstract class Enum extends EnumClabs
{
    public static function byName($name)
    {
        return new static($name);
    }

    public function toString()
    {
        return (string) $this->value;
    }
}