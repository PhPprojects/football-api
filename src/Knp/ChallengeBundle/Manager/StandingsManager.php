<?php

namespace Knp\ChallengeBundle\Manager;

use Doctrine\ORM\EntityManager;
use Knp\ChallengeBundle\Entity\Team;
use Knp\ChallengeBundle\Entity\Standings;

class StandingsManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getStandings($from, $to)
    {
        $data = $this->em->getRepository('ChallengeBundle:Team')->findAll();

        foreach ($data as $team) {
            $standings[] = $this->getStandingsData($team, $from, $to);
        }

        usort($standings, array($this, "cmpTeam"));

        $standings = $this->setPlaces($standings);

        return $standings;
    }

    public function setStandings($standings)
    {
        foreach ($standings as $standingsMember) {
            $this->em->persist($standingsMember);
        }

        $this->em->flush();

        return true;
    }

    public function removeStandings($date)
    {
        $standings = $this->em->getRepository('ChallengeBundle:Standings')->findStandingsForDate($date);

        foreach ($standings as $standingsMember)
        {
            $this->em->remove($standingsMember);
        }

        $this->em->flush();
    }

    public function getStandingsData(Team $team, $from, $to)
    {
        $standingsMember = new Standings();

        $standingsMember->setDateFrom(new \DateTime($from));
        $standingsMember->setDateTo(new \DateTime($to));
        $standingsMember->setTeam($team);

        foreach ($team->getHomeTeamGames() as $game) {
            if ($game->getDateString() >= $from && $game->getDateString() <= $to) {
                if ($game->getHomeTeamScore() < $game->getAwayTeamScore()) {
                    $standingsMember->setLosses($standingsMember->getLosses() + 1);
                }
                elseif ($game->getHomeTeamScore() > $game->getAwayTeamScore()) {
                    $standingsMember->setWins($standingsMember->getWins() + 1);
                }
                else {
                    $standingsMember->setDraws($standingsMember->getDraws() + 1);
                }

                $standingsMember->setPlayed($standingsMember->getPlayed()+1);
            }
        }

        foreach ($team->getAwayTeamGames() as $game) {
            if ($game->getDateString() >= $from && $game->getDateString() <= $to) {
                if ($game->getAwayTeamScore() < $game->getHomeTeamScore()) {
                    $standingsMember->setLosses($standingsMember->getLosses() + 1);
                }
                elseif ($game->getAwayTeamScore() > $game->getHomeTeamScore()) {
                    $standingsMember->setWins($standingsMember->getWins() + 1);
                }
                else {
                    $standingsMember->setDraws($standingsMember->getDraws() + 1);
                }

                $standingsMember->setPlayed($standingsMember->getPlayed()+1);
            }
        }

        $points = $this->considerPoints($standingsMember);
        $standingsMember->setPoints($points);

        return $standingsMember;
    }

    public function cmpTeam(Standings $a, Standings $b)
    {
        $ap = $a->getPoints();
        $bp = $b->getPoints();
        if ($ap == $bp) {
            return 0;
        }
        return ($ap > $bp) ? -1 : +1;
    }

    public function considerPoints($standingsMember)
    {
        return $standingsMember->getWins() * 3 + $standingsMember->getDraws();
    }

    public function setPlaces($standings)
    {
        $place = 1;
        foreach ($standings as $standingsMember) {
            $result[] = $standingsMember->setPlace($place++);
        }

        return $result;
    }
}