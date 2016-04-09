<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class tests the TestController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class TestControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadTestData',
    ];

    /**
     * Test of getTestsAction method
     */
    public function testGetTestsAction()
    {
        $response = $this->defaultGetListTest($this->getUrl('get_tests'));
        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThan(0, count($data['items']));
    }

    /**
     * Test of getTestAction method
     */
    public function testGetTestAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $response = $this->defaultGetTest($this->getUrl('get_test', ['id' => $test1Id]));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals('Test 1 : la vie des pingouins', $data['title']);
    }

    /**
     * Test of deleteTestAction method
     */
    public function testDeleleTestsAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $response = $this->defaultDeleteTest($this->getUrl('delete_tests', ['id' => $test1Id]));
    }

    /**
     * Test of postTestAction method
     * @param array $test
     * @dataProvider testProvider
     */
    public function testPostTestsAction($test)
    {
        $response = $this->defaultPostTest($this->getUrl('post_tests'), ['test' => $test]);

        $this->client->request('POST', $this->getUrl('post_tests'), ['test' => $test]);
        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
    }

    /**
     * Test of putTestAction method
     * @param array $test
     * @dataProvider testProvider
     */
    public function testPutTestsAction($test)
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $response = $this->defaultPutTest($this->getUrl('put_tests', ['id' => $test1Id]), ['test' => $test]);

        // Check update
        $this->client->request('GET', $this->getUrl('get_test', ['id' => $test1Id]));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($test['title'], $data['title']);
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
