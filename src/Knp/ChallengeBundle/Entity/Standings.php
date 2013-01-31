<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\SerializerBundle\Annotation\Exclude;
use JMS\SerializerBundle\Annotation\Accessor;

/**
 * Standings
 *
 * @ORM\Table(name="standings")
 * @ORM\Entity(repositoryClass="Knp\ChallengeBundle\Entity\StandingsRepository")
 */
class Standings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Exclude
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFrom", type="date")
     * @Exclude
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTo", type="date")
     * @Exclude
     */
    private $dateTo;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @Accessor(getter="getTeamName")
     */
    private $team;

    /**
     * @var integer
     *
     * @ORM\Column(name="played", type="integer")
     */
    private $played;

    /**
     * @var integer
     *
     * @ORM\Column(name="wins", type="integer")
     */
    private $wins;

    /**
     * @var integer
     *
     * @ORM\Column(name="draws", type="integer")
     */
    private $draws;

    /**
     * @var integer
     *
     * @ORM\Column(name="losses", type="integer")
     */
    private $losses;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="place", type="integer")
     */
    private $place;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return Standings
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    
        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return Standings
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    
        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set team
     *
     * @param integer $team
     * @return Standings
     */
    public function setTeam($team)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return Team object
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return string
     */
    public function getTeamName()
    {
        return $this->team->getName();
    }

    /**
     * Set played
     *
     * @param integer $played
     * @return Standings
     */
    public function setPlayed($played)
    {
        $this->played = $played;
    
        return $this;
    }

    /**
     * Get played
     *
     * @return integer 
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * Set wins
     *
     * @param integer $wins
     * @return Standings
     */
    public function setWins($wins)
    {
        $this->wins = $wins;
    
        return $this;
    }

    /**
     * Get wins
     *
     * @return integer 
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Set losses
     *
     * @param integer $losses
     * @return Standings
     */
    public function setLosses($losses)
    {
        $this->losses = $losses;
    
        return $this;
    }

    /**
     * Get losses
     *
     * @return integer 
     */
    public function getLosses()
    {
        return $this->losses;
    }

    /**
     * Set points
     *
     * @param integer $points
     * @return Standings
     */
    public function setPoints($points)
    {
        $this->points = $points;
    
        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set place
     *
     * @param integer $place
     * @return Standings
     */
    public function setPlace($place)
    {
        $this->place = $place;
    
        return $this;
    }

    /**
     * Get place
     *
     * @return integer 
     */
    public function getPlace()
    {
        return $this->place;
    }

    public function getDraws()
    {
        return $this->draws;
    }

    public function setDraws($draws)
    {
        $this->draws = $draws;
    }
}
