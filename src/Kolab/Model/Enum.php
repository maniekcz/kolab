<?php

namespace Kolab\Model;

use MyCLabs\Enum\Enum as EnumClabs;

class Enum extends EnumClabs
{
    public static function byName($name) {
        return new self($name);
    }

    public function toString()
    {
        return (string) $this->value;
    }
}