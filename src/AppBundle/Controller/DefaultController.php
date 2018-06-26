<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends FOSRestController
{
    /**
     * @Route(name="homepage", path="/")
     * @Method("GET")
     *
     * @param Request $request
     * @return View
     */
    public function createAction(Request $request)
    {
        return $this->view([]);
    }
}
