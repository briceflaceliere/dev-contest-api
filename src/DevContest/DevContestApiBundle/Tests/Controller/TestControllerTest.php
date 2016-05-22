<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\SubTest\DeleteSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\GetSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PaginatorSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PostPutSubTest;
use DevContest\DevContestApiBundle\Tests\WebTestCase;

/**
 * Class tests the TestController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class TestControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadTestData',
    ];

    /**
     * Test of getTestsAction method
     */
    public function testGetTestsAction()
    {
        $subTest = new PaginatorSubTest($this->getUrl('get_tests'));
        $subTest->setItemsNotEmpty(true)
                ->setItemsKeys(['id', 'title', 'description']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of getTestAction method
     */
    public function testGetTestAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $subTest = new GetSubTest($this->getUrl('get_test', ['id' => $test1Id]));
        $subTest->setItemKeys(['id', 'title', 'description']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of deleteTestAction method
     */
    public function testDeleleTestsAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $subTest = new DeleteSubTest($this->getUrl('delete_tests', ['id' => $test1Id]));
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of postTestAction method
     * @param array $test
     * @dataProvider testProvider
     */
    public function testPostTestsAction($test)
    {
        $subTest = new PostPutSubTest($this->getUrl('post_tests'), 'POST', ['test' => $test]);
        $subTest->addCheckValue('title', $test['title']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of putTestAction method
     * @param array $test
     * @dataProvider testProvider
     */
    public function testPutTestsAction($test)
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();
        $subTest = new PostPutSubTest($this->getUrl('put_tests', ['id' => $test1Id]), 'PUT', ['test' => $test]);
        $subTest->addCheckValue('title', $test['title']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test data provider
     * @return array
     */
    public function testProvider()
    {
        return [
            [['title' => 'test_title_1', 'description' => 'test_description_1']],
        ];
    }
}
