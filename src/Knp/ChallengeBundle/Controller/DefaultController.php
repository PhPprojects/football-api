<?php

namespace Knp\ChallengeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ChallengeBundle:Default:index.html.twig');
    }
}
