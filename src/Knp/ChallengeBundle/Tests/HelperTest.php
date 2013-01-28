<?php

namespace Knp\ChallengeBundle\Tests;

use Symfony\Component\DomCrawler\Crawler;
use Knp\ChallengeBundle\Entity\Team;

class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerCmpTeam
     */
    public function testCmpTeam($data, $result)
    {
        $helperMock = $this->getMockBuilder('Knp\ChallengeBundle\Helper')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock()
        ;

        $teamA = new Team();
        $teamB = new Team();

        $teamA->setPoints($data[0]);
        $teamB->setPoints($data[1]);

        $this->assertEquals($result, $helperMock->cmpTeam($teamA, $teamB));
    }

    public function testGetContent()
    {
        $helperMock = $this->getMockBuilder('Knp\ChallengeBundle\Helper')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock()
        ;

        $this->assertContains('<td class="team team-b ">', $helperMock->getContent(0));
        $this->assertContains('View events</a>', $helperMock->getContent(5));
        $this->assertFalse($helperMock->getContent(100500));
    }

    public function testGetTimestampFromTable()
    {
        $helperMock = $this->getMockBuilder('Knp\ChallengeBundle\Helper')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($helperMock, 'getTimestampFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('attrDataValueForTr0Td0Span', $reflMethod->invokeArgs($helperMock, array($crawler, 0)));
        $this->assertEquals('attrDataValueForTr1Td0Span', $reflMethod->invokeArgs($helperMock, array($crawler, 1)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($helperMock, array($crawler, 1)));
    }

    public function testGetTeamFromTable()
    {
        $helperMock = $this->getMockBuilder('Knp\ChallengeBundle\Helper')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($helperMock, 'getTeamFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('attrTitleForTr0Td0A', $reflMethod->invokeArgs($helperMock, array($crawler, 0, 0)));
        $this->assertEquals('attrTitleForTr0Td1A', $reflMethod->invokeArgs($helperMock, array($crawler, 0, 1)));
        $this->assertEquals('attrTitleForTr0Td2A', $reflMethod->invokeArgs($helperMock, array($crawler, 0, 2)));
        $this->assertEquals('attrTitleForTr0Td3A', $reflMethod->invokeArgs($helperMock, array($crawler, 0, 3)));
        $this->assertEquals('attrTitleForTr1Td2A', $reflMethod->invokeArgs($helperMock, array($crawler, 1, 2)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($helperMock, array($crawler, 1, 3)));
    }

    public function testGetScoreFromTable()
    {
        $helperMock = $this->getMockBuilder('Knp\ChallengeBundle\Helper')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($helperMock, 'getScoreFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('textForTr0Td3A', $reflMethod->invokeArgs($helperMock, array($crawler, 0)));
        $this->assertEquals('textForTr1Td3A', $reflMethod->invokeArgs($helperMock, array($crawler, 1)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($helperMock, array($crawler, 1)));
    }

    protected function simpleTableData()
    {
        return $table = "
        <!DOCTYPE html>
        <html>
            <body>
            <table>
            <tbody>
                <tr>
                    <td>
                        <a title='attrTitleForTr0Td0A'>
                            anchor
                        </a>
                    </td>
                    <td>
                        <span data-value='attrDataValueForTr0Td0Span'>
                            <a title='attrTitleForTr0Td1A'>
                                anchor
                            </a>
                        </span>
                    </td>
                    <td>
                        <a title='attrTitleForTr0Td2A'>
                            textForTr0Td2A
                        </a>
                    </td>
                    <td>
                        <a title='attrTitleForTr0Td3A'>textForTr0Td3A</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a title='attrTitleForTr1Td0A'>
                            anchor
                        </a>
                    </td>
                    <td>
                        <span data-value='attrDataValueForTr1Td0Span'>
                            <a title='attrTitleForTr1Td1A'>
                                anchor
                            </a>
                        </span>
                    </td>
                    <td>
                        <a title='attrTitleForTr1Td2A'>
                            textForTr1Td2A
                        </a>
                    </td>
                    <td>
                        <a title='attrTitleForTr1Td3A'>textForTr1Td3A</a>
                    </td>
                </tr>
            </tbody>
            </table>
            </body>
        </html>
        ";
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