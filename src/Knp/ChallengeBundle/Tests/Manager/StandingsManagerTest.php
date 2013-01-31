<?php

namespace Knp\ChallengeBundle\Tests\Manager;

use Knp\ChallengeBundle\Entity\Standings;

class StandingsManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerCmpTeam
     */
    public function testCmpTeam($data, $result)
    {
        $StandingsManagerMock = $this->getMockBuilder('Knp\ChallengeBundle\Manager\StandingsManager')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock()
        ;

        $teamA = new Standings();
        $teamB = new Standings();

        $teamA->setPoints($data[0]);
        $teamB->setPoints($data[1]);

        $this->assertEquals($result, $StandingsManagerMock->cmpTeam($teamA, $teamB));
    }

    public function providerCmpTeam()
    {
        return array(
            array(array(5, 6), 1),
            array(array(6, 5), -1),
            array(array(0, 3), 1),
            array(array(4, 0), -1),
        );
    }
}