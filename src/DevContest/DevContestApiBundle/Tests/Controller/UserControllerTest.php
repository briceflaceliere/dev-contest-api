<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class UserControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
    ];

    public function testGetUsersAction()
    {
        $response = $this->defaultGetListTest($this->getUrl('get_users'));
        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThan(0, count($data['items']));
    }

    public function testGetUserAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultGetTest($this->getUrl('get_user', ['id' => $user1Id]));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('nickname', $data);
        $this->assertEquals('brice', $data['nickname']);
    }

    public function testDeleleUsersAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultDeleteTest($this->getUrl('delete_users', ['id' => $user1Id]));
    }

    /**
     * @dataProvider userProvider
     */
    public function testPostUsersAction($user)
    {
        $response = $this->defaultPostTest($this->getUrl('post_users'), ['user' => $user]);

        // Check duplicate nickname validator
        $this->client->request('POST', $this->getUrl('post_users'), ['user' => $user]);
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    /**
     * @dataProvider userProvider
     */
    public function testPutUsersAction($user)
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultPutTest($this->getUrl('put_users', ['id' => $user1Id]), ['user' => $user]);

        // Check update
        $this->client->request('GET', $this->getUrl('get_user', ['id' => $user1Id]));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($user['nickname'], $data['nickname']);
    }

    public function userProvider()
    {
        return [
            [['nickname' => 'tester_phpunit_1']],
            [['nickname' => 'tester_phpunit_2']],
        ];
    }
}
