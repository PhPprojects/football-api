<?php

namespace Knp\ChallengeBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class ApiController extends FOSRestController
{
    /**
     * @QueryParam(name="from", requirements="\d{4}-\d{2}-\d{2}", default="1900-01-01", strict=true, nullable=true, description="Date from")
     * @QueryParam(name="to", requirements="\d{4}-\d{2}-\d{2}", default="2200-01-01", strict=true, nullable=true, description="Date to")
     */
    public function getStandingsAction(ParamFetcher $paramFetcher)
    {
        $from = $paramFetcher->get('from');
        $to = $paramFetcher->get('to');

        $data = $this->getDoctrine()->getRepository('ChallengeBundle:Team')->findAll();

        foreach ($data as $team) {
            $aTeam[] = $this->get('challenge.helper')->getStandingsData($team, $from, $to);
        }

        usort($aTeam, array($this->get('challenge.helper'), "cmpTeam"));

        //Set places
        $place = 1;
        foreach ($aTeam as $team) {
            $aTeam[] = $team->setPlace($place++);
        }

        $view = $this->view($aTeam, 200);
        $view->setFormat('json');

        return $this->handleView($view);
    }
}