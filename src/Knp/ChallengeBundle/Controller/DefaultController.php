<?php

namespace Knp\ChallengeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use Knp\ChallengeBundle\Entity\Team;
use Knp\ChallengeBundle\Entity\Game;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if (null != $request->query->get('teamName')) {
            $teamName = $request->query->get('teamName');
            $team = $this->getDoctrine()
                ->getRepository('ChallengeBundle:Team')
                ->findOneByName($teamName);

            if ($team) {
            $games = $this->getDoctrine()
                ->getRepository('ChallengeBundle:Game')
                ->getAllGamesByTeam($team);
            }
            else {
                $this->get('session')->getFlashBag()->add('notice', 'Invalid team name');
                $games = array();
            }
        }
        else {
            $games = $this->getDoctrine()
                ->getRepository('ChallengeBundle:Game')
                ->getAllGames();
        }

        return $this->render('ChallengeBundle:Default:index.html.twig', array(
            'games' => $games,
        ));
    }

    public function importAction()
    {
        $em = $this->getDoctrine()->getManager();
        // Walk through the pages
        for ($page = 0; $matchesTable = $this->get('challenge.helper')->getContent($page); $page++) {
            echo 'Import page: '.$page.'<br />';
            $crawler = new Crawler($matchesTable);
            // Walk through the table
            for ($tr=0; $tr < $crawler->filter('tbody > tr')->count(); $tr++) {
                $game = new Game();
                echo 'Import tr: '.$tr.'<br />';
                // Get date
                $timestamp = $crawler->filter('tbody > tr')
                    ->eq($tr)
                    ->filter('td')
                    ->eq(1)
                    ->filter('span')
                    ->attr('data-value');
                $date = date('Y-m-d', $timestamp);
                $date = new \DateTime($date);
                $game->setDate($date);

                // Home Team
                $homeTeamName = $crawler->filter('tbody > tr')
                    ->eq($tr)
                    ->filter('td')
                    ->eq(2)
                    ->filter('a')
                    ->attr('title');
                $homeTeam = $this->getDoctrine()->getRepository('ChallengeBundle:Team')->findOneByName($homeTeamName);
                if (!$homeTeam) {
                    $homeTeam = new Team();
                    $homeTeam->setName($homeTeamName);
                    $em->persist($homeTeam);
                }
                $game->setHomeTeam($homeTeam);

                // Score
                $score = $crawler->filter('tbody > tr')
                    ->eq($tr)
                    ->filter('td')
                    ->eq(3)
                    ->filter('a')
                    ->text();
                $scoreArray = explode('-', $score);
                $game->setHomeTeamScore(trim($scoreArray['0']));
                $game->setAwayTeamScore(trim($scoreArray['1']));

                // Away Team
                $awayTeamName = $crawler->filter('tbody > tr')
                    ->eq($tr)
                    ->filter('td')
                    ->eq(4)
                    ->filter('a')
                    ->attr('title');
                $awayTeam = $this->getDoctrine()->getRepository('ChallengeBundle:Team')->findOneByName($awayTeamName);
                if (!$awayTeam) {
                    $awayTeam = new Team();
                    $awayTeam->setName($awayTeamName);
                    $em->persist($awayTeam);
                }
                $game->setAwayTeam($awayTeam);
                if (!$this->getDoctrine()->getRepository('ChallengeBundle:Game')->existThisGame($game)) {
                    $em->persist($game);
                }
                $em->flush();
            }
        }
        return new Response('Successful import');
    }
}
