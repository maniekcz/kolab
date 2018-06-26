<?php

namespace Kolab\Model;

interface Projections
{
    public function __invoke(bool $keepRunning = true);
}