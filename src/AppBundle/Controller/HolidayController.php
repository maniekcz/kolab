<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Kolab\Customer\Domain\CustomerId;
use Kolab\Holiday\Application\Command\CreateHoliday;
use Kolab\Holiday\Application\Query\ListHolidays;
use Kolab\Holiday\Domain\HolidayId;
use FOS\RestBundle\Controller\Annotations\Route;
use Kolab\Holiday\Infrastructure\Projection\HolidayRead;
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
            CustomerId::generate()->toString(),
            '2017-12-12'
        );
        $this->get('prooph_service_bus.kolab.command_bus')->dispatch($command);

        return $this->view([]);
    }

    /**
     * @Route(name="kolab.holiday.list", path="/holiday")
     * @Method("GET")
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function listAction(Request $request)
    {
        $holidays = [];
        $this->get('prooph_service_bus.kolab.query_bus')
            ->dispatch(
                ListHolidays::withData(10)
            )
            ->then(
                function ($result) use (&$holidays) {
                    $holidays = $result;
                }
            );
        return $this->view($holidays);
    }

    /**
     * @Route(name="kolab.holiday.get", path="/holiday/{holiday}")
     * @Method("GET")
     *
     * @param HolidayRead $holiday
     * @return \FOS\RestBundle\View\View
     */
    public function getAction(HolidayRead $holiday)
    {
        return $this->view(['holiday' => $holiday]);
    }
}
