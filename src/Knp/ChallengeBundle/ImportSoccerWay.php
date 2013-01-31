<?php

namespace Knp\ChallengeBundle;

use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;
use Knp\ChallengeBundle\Entity\Team;
use Knp\ChallengeBundle\Entity\Game;
use Doctrine\ORM\EntityManager;
use Knp\ChallengeBundle\Manager\TeamManager;
use Knp\ChallengeBundle\Manager\GameManager;

class ImportSoccerWay
{
    private $em;

    private $teamManager;

    private $gameManager;

    public function __construct(EntityManager $entityManager, TeamManager $teamManager, GameManager $gameManager)
    {
        $this->em = $entityManager;
        $this->teamManager = $teamManager;
        $this->gameManager = $gameManager;
    }

    public function fetchData()
    {
        // Walk through the pages
        for ($page = 0; $matchesTable = $this->getContent($page); $page++) {
            $crawler = new Crawler($matchesTable);

            // Walk through the table
            for ($tr=0; $tr < $crawler->filter('tbody > tr')->count(); $tr++) {

                // Date
                $timestamp = $this->getTimestampFromTable($crawler, $tr);
                $date = $this->getObjDateFromTimestamp('Y-m-d', $timestamp);

                // Home Team
                $homeTeamName = $this->getTeamFromTable($crawler, $tr, 2);
                $homeTeam = $this->teamManager->getTeamByName($homeTeamName);

                // Score
                $score = $this->getScoreFromTable($crawler, $tr);
                $scoreArray = $this->getScoreArray($score);

                // Away Team
                $awayTeamName = $this->getTeamFromTable($crawler, $tr, 4);
                $awayTeam = $this->teamManager->getTeamByName($awayTeamName);

                $this->gameManager->setGameIfNotExist($date, $homeTeam, $awayTeam, $scoreArray);
            }
        }
        return true;
    }

    public function cmpTeam(Team $a, Team $b)
    {
        $ap = $a->getPoints();
        $bp = $b->getPoints();
        if ($ap == $bp) {
            return 0;
        }
        return ($ap > $bp) ? -1 : +1;
    }

    public function getStandingsData(Team $team, $from, $to)
    {
        foreach ($team->getHomeTeamGames() as $game) {
            if ($game->getDateString() >= $from && $game->getDateString() <= $to) {
                if ($game->getHomeTeamScore() < $game->getAwayTeamScore()) {
                    $team->setLosses($team->getLosses() + 1);
                }
                elseif ($game->getHomeTeamScore() > $game->getAwayTeamScore()) {
                    $team->setWins($team->getWins() + 1);
                }
                else {
                    $team->setDraws($team->getDraws() + 1);
                }

                $team->setPlayed($team->getPlayed()+1);
            }
        }

        foreach ($team->getAwayTeamGames() as $game) {
            if ($game->getDateString() >= $from && $game->getDateString() <= $to) {
                if ($game->getAwayTeamScore() < $game->getHomeTeamScore()) {
                    $team->setLosses($team->getLosses() + 1);
                }
                elseif ($game->getAwayTeamScore() > $game->getHomeTeamScore()) {
                    $team->setWins($team->getWins() + 1);
                }
                else {
                    $team->setDraws($team->getDraws() + 1);
                }

                $team->setPlayed($team->getPlayed()+1);
            }
        }

        $team->considerPoints();

        return $team;
    }

    public function getContent($page)
    {
        if ($page != 0) {
            $page = '-'.$page;
        }
        $client = $client = new Client('http://www.soccerway.com/a/block_competition_matches?block_id=page_competition_1_block_competition_matches_7&callback_params=%7B%22page%22%3A%22-1%22%2C%22round_id%22%3A%2214829%22%2C%22outgroup%22%3A%22%22%2C%22view%22%3A%222%22%7D&action=changePage&params=%7B%22page%22%3A'.$page.'%7D');
        $request = $client->get();
        $response = $request->send();

        $responseArray = $response->json();
        $matchesTable = $responseArray['commands']['0']['parameters']['content'];

        // If empty table
        if (strlen($matchesTable) <= 93) {
            return false;
        }

        return $matchesTable;
    }

    private function getObjDateFromTimestamp($format ,$timestamp)
    {
        $date = date($format, $timestamp);
        return new \DateTime($date);
    }

    private function getScoreArray($score)
    {
        $scoreArray = explode('-', $score);
        $homeTeamScore = trim($scoreArray['0']);
        $awayTeamScore = trim($scoreArray['1']);
        return array(
            'homeScore' => $homeTeamScore,
            'awayScore' => $awayTeamScore,
        );
    }

    private function getTimestampFromTable(Crawler $crawler, $tr)
    {
        return $crawler->filter('tbody > tr')
            ->eq($tr)
            ->filter('td')
            ->eq(1)
            ->filter('span')
            ->attr('data-value');
    }

    private function getTeamFromTable(Crawler $crawler, $tr, $td)
    {
        return $crawler->filter('tbody > tr')
            ->eq($tr)
            ->filter('td')
            ->eq($td)
            ->filter('a')
            ->attr('title');
    }

    private function getScoreFromTable(Crawler $crawler, $tr)
    {
        return $crawler->filter('tbody > tr')
            ->eq($tr)
            ->filter('td')
            ->eq(3)
            ->filter('a')
            ->text();
    }
}
