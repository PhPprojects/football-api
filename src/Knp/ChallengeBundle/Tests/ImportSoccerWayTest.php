<?php

namespace Knp\ChallengeBundle\Tests;

use Symfony\Component\DomCrawler\Crawler;

class ImportSoccerWayTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContent()
    {
        $importSoccerWayMock = $this->getMockBuilder('Knp\ChallengeBundle\ImportSoccerWay')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock()
        ;

        $this->assertContains('<td class="team team-b ">', $importSoccerWayMock->getContent(0));
        $this->assertContains('View events</a>', $importSoccerWayMock->getContent(5));
        $this->assertFalse($importSoccerWayMock->getContent(100500));
    }

    public function testGetTimestampFromTable()
    {
        $importSoccerWayMock = $this->getMockBuilder('Knp\ChallengeBundle\ImportSoccerWay')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($importSoccerWayMock, 'getTimestampFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('attrDataValueForTr0Td0Span', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0)));
        $this->assertEquals('attrDataValueForTr1Td0Span', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1)));
    }

    public function testGetTeamFromTable()
    {
        $importSoccerWayMock = $this->getMockBuilder('Knp\ChallengeBundle\ImportSoccerWay')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($importSoccerWayMock, 'getTeamFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('attrTitleForTr0Td0A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0, 0)));
        $this->assertEquals('attrTitleForTr0Td1A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0, 1)));
        $this->assertEquals('attrTitleForTr0Td2A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0, 2)));
        $this->assertEquals('attrTitleForTr0Td3A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0, 3)));
        $this->assertEquals('attrTitleForTr1Td2A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1, 2)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1, 3)));
    }

    public function testGetScoreFromTable()
    {
        $importSoccerWayMock = $this->getMockBuilder('Knp\ChallengeBundle\ImportSoccerWay')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $reflMethod = new \ReflectionMethod($importSoccerWayMock, 'getScoreFromTable');
        $reflMethod->setAccessible(true);

        $crawler = new Crawler($this->simpleTableData());

        $this->assertEquals('textForTr0Td3A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 0)));
        $this->assertEquals('textForTr1Td3A', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1)));
        $this->assertNotEquals('something', $reflMethod->invokeArgs($importSoccerWayMock, array($crawler, 1)));
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
}