<?php

namespace Knp\ChallengeBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Behat\Event\FeatureEvent;

use Knp\ChallengeBundle\Entity\Team;
use Knp\ChallengeBundle\Entity\Game;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^на сайт добавлены жанры:$/
     */
//    public function naSaitDobavlienyZhanry(TableNode $table)
//    {
//        $em = $this->getEntityManager();
//
//        foreach ($table->getHash() as $genreHash) {
//            $game = new \Knp\ChallengeBundle\Entity\Game();
//            game->setName($genreHash['name']);
//
//            $em->persist($genre);
//        }
//        $em->flush();
//    }

    /**
     * @Given /^there are teams:$/
     */
    public function thereAreTeams(TableNode $table)
    {
        $em = $this->getEntityManager();

        foreach ($table->getHash() as $teamHash) {
            $team = new Team();
            $team->setName($teamHash['name']);

            $em->persist($team);
        }
        $em->flush();
    }

    /**
     * @Given /^there are games:$/
     */
    public function thereAreGames(TableNode $table)
    {
        $em = $this->getEntityManager();

        foreach ($table->getHash() as $gameHash) {
            $game = new Game();
            $game->setDate(new \DateTime($gameHash['date']));
            $game->setHomeTeamScore($gameHash['homeTeamScore']);
            $game->setAwayTeamScore($gameHash['awayTeamScore']);
            $game->setAwayTeam($gameHash['awayTeamScore']);

            $homeTeam = $em->getRepository('ChallengeBundle:Team')
                ->findOneByName($gameHash['homeTeamName']);
            $game->setHomeTeam($homeTeam);

            $awayTeam = $em->getRepository('ChallengeBundle:Team')
                ->findOneByName($gameHash['awayTeamName']);
            $game->setAwayTeam($awayTeam);

            $em->persist($game);
        }
        $em->flush();
    }

        /** @AfterScenario */
        public function cleanDatabase()
        {
            foreach (array('Game', 'Team') as $entity) {
                $this->getEntityManager()->getRepository("ChallengeBundle:$entity")
                    ->createQueryBuilder('e')
                    ->delete()
                    ->getQuery()
                    ->execute();
            }
        }

    private function getEntityManager()
    {
        return $this->kernel->getContainer()->get('doctrine.orm.entity_manager');
    }
}
