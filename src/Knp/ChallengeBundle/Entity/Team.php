<?php

namespace Knp\ChallengeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\SerializerBundle\Annotation\Exclude;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Game", mappedBy="homeTeam")
     * @Exclude
     */
    private $homeTeamGames;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Game", mappedBy="awayTeam")
     * @Exclude
     */
    private $awayTeamGames;

    public function __construct ()
    {
        $this->homeTeamGames = new ArrayCollection();
        $this->awayTeamGames = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     * @return Team
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * @param  $awayTeamGames
     */
    public function setAwayTeamGames($awayTeamGames)
    {
        $this->awayTeamGames = $awayTeamGames;
    }

    /**
     * @return
     */
    public function getAwayTeamGames()
    {
        return $this->awayTeamGames;
    }

    /**
     * @param  $homeTeamGames
     */
    public function setHomeTeamGames($homeTeamGames)
    {
        $this->homeTeamGames = $homeTeamGames;
    }

    /**
     * @return
     */
    public function getHomeTeamGames()
    {
        return $this->homeTeamGames;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
