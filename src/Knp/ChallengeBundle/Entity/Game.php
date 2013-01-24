<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Knp\ChallengeBundle\Entity\GameRepository")
 */
class Game
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="homeTeamGames")
     * @ORM\JoinColumn(name="home_team_id", referencedColumnName="id")
     */
    private $homeTeam;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="awayTeamGames")
     * @ORM\JoinColumn(name="away_team_id", referencedColumnName="id")
     */
    private $awayTeam;

    /**
     * @var integer
     *
     * @ORM\Column(name="homeTeamScore", type="integer")
     */
    private $homeTeamScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="awayTeamScore", type="integer")
     */
    private $awayTeamScore;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Game
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    public function getDateString()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * Set homeTeam
     *
     * @param integer $homeTeam
     * @return Game
     */
    public function setHomeTeam($homeTeam)
    {
        $this->homeTeam = $homeTeam;
    
        return $this;
    }

    /**
     * Get homeTeam
     *
     * @return integer 
     */
    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    /**
     * Set awayTeam
     *
     * @param integer $awayTeam
     * @return Game
     */
    public function setAwayTeam($awayTeam)
    {
        $this->awayTeam = $awayTeam;
    
        return $this;
    }

    /**
     * Get awayTeam
     *
     * @return integer 
     */
    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    /**
     * Set homeTeamScore
     *
     * @param integer $homeTeamScore
     * @return Game
     */
    public function setHomeTeamScore($homeTeamScore)
    {
        $this->homeTeamScore = $homeTeamScore;
    
        return $this;
    }

    /**
     * Get homeTeamScore
     *
     * @return integer 
     */
    public function getHomeTeamScore()
    {
        return $this->homeTeamScore;
    }

    /**
     * Set awayTeamScore
     *
     * @param integer $awayTeamScore
     * @return Game
     */
    public function setAwayTeamScore($awayTeamScore)
    {
        $this->awayTeamScore = $awayTeamScore;
    
        return $this;
    }

    /**
     * Get awayTeamScore
     *
     * @return integer 
     */
    public function getAwayTeamScore()
    {
        return $this->awayTeamScore;
    }

    public function getScore()
    {
        return $this->homeTeamScore.'-'.$this->awayTeamScore;
    }
}
