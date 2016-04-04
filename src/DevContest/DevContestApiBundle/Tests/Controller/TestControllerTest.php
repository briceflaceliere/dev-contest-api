<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class TestControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadTestData',
    ];

    public function testGetTestsAction()
    {
        $response = $this->defaultGetListTest($this->getUrl('get_tests'));
        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThan(0, count($data['items']));
    }

    public function testGetTestAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $response = $this->defaultGetTest($this->getUrl('get_test', ['id' => $test1Id]));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals('Test 1 : la vie des pingouins', $data['title']);
    }

    public function testDeleleTestsAction()
    {
        $test1Id = $this->fixtures->getReference('test1')->getId();

        $response = $this->defaultDeleteTest($this->getUrl('delete_tests', ['id' => $test1Id]));
    }

    /**
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

    public function testProvider()
    {
        return [
            [['title' => 'test_title_1', 'description' => 'test_description_1']],
        ];
    }
}
