<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use DevContest\DevContestApiBundle\Tests\SubTest\DeleteSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\GetSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PaginatorSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PostPutSubTest;

/**
 * Class tests the ContestController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class ContestControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadContestData',
    ];

    /**
     * Test of getContestsAction method
     */
    public function testGetContestsAction()
    {
        $subTest = new PaginatorSubTest($this->getUrl('get_contests'));
        $subTest->setItemsNotEmpty(true);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of getContestAction method
     */
    public function testGetContestAction()
    {
        $contest1Id = $this->fixtures->getReference('contest1')->getId();

        $subTest = new GetSubTest($this->getUrl('get_contest', ['id' => $contest1Id]));
        $subTest->setItemKeys(['id', 'name', 'start_ts', 'languages']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of deleleContestsAction method
     */
    public function testDeleleContestsAction()
    {
        $contest1Id = $this->fixtures->getReference('contest1')->getId();

        $subTest = new DeleteSubTest($this->getUrl('delete_contests', ['id' => $contest1Id]));
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of post$ContestAction method
     *
     * @param array $contest
     * @dataProvider contestProvider
     */
    public function testPostContestsAction($contest)
    {
        $subTest = new PostPutSubTest($this->getUrl('post_contests'), 'POST', ['contest' => $contest]);
        $subTest->addCheckValue('name', $contest['name']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of put$ContestAction method
     *
     * @param array $contest
     * @dataProvider contestProvider
     */
    public function testPutContestsAction($contest)
    {
        $contest1Id = $this->fixtures->getReference('contest1')->getId();

        $subTest = new PostPutSubTest($this->getUrl('put_contests', ['id' => $contest1Id]), 'PUT', ['contest' => $contest]);
        $subTest->addCheckValue('name', $contest['name']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Contest data provider
     * @return array
     */
    public function contestProvider()
    {
        return [
            [['name' => 'Contest 3']],
        ];
    }
}
