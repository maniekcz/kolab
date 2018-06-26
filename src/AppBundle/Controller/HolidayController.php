<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Kolab\Holiday\Application\Command\CreateHoliday;
use Kolab\Holiday\Domain\HolidayId;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class HolidayController extends FOSRestController
{
    /**
     * @Route(name="kolab.holiday.create", path="/holiday")
     * @Method("POST")
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function createAction(Request $request)
    {
        $command = CreateHoliday::withData(
            HolidayId::generate()->toString(),
            '2017-12-12'
        );
        $this->get('prooph_service_bus.kolab.command_bus')->dispatch($command);

        return $this->view([]);
    }
}
