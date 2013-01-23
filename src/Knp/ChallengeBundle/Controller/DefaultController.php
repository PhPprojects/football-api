<?php

namespace Knp\ChallengeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CallengeBundle:Default:index.html.twig');
    }
}
