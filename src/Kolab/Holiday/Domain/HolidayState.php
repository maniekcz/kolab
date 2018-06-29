<?php

namespace Kolab\Holiday\Domain;

use Kolab\Model\Enum;

/**
* @method static NEW()
* @method static APPROVED()
* @method static REJECTED()
*/
class HolidayState extends Enum
{
    const NEW = 'NEW';
    const APPROVED = 'APPROVED';
    const REJECTED = 'REJECTED';
    const DELETED = 'DELETED';
}