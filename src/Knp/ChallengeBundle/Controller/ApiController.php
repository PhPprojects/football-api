<?php

namespace Knp\ChallengeBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;

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

        $standings = $this->getDoctrine()->getRepository('ChallengeBundle:Standings')->findStandingsFromPeriod($from, $to);
        if (empty($standings)) {
            // @ToDo Set standings
            $standings = $this->get('challenge.standings_manager')->getStandings($from, $to);

            if (!$this->get('challenge.standings_manager')->setStandings($standings)) {
                return new Response('Can\'t save data', 400);
            }
        }

        $view = $this->view($standings, 200);
        $view->setFormat('json');

        return $this->handleView($view);
    }
}