<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class tests the UserController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class UserControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
    ];

    /**
     * Test of getUsersAction method
     */
    public function testGetUsersAction()
    {
        $response = $this->defaultGetListTest($this->getUrl('get_users'));

        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThan(0, count($data['items']));
        $this->assertArrayHasKey('id', $data['items'][0]);
        $this->assertArrayHasKey('username', $data['items'][0]);
        $this->assertArrayNotHasKey('email', $data['items'][0]);
        $this->assertArrayNotHasKey('password', $data['items'][0]);
    }

    /**
     * Test of getUserAction method
     */
    public function testGetUserAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultGetTest($this->getUrl('get_user', ['id' => $user1Id]));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('username', $data);
        $this->assertArrayNotHasKey('email', $data);
        $this->assertArrayNotHasKey('password', $data);
        $this->assertEquals('brice', $data['username']);
    }

    /**
     * Test of getUserPrivateAction method
     */
    public function testGetUserPrivateAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultGetTest($this->getUrl('get_user_private', ['id' => $user1Id]));

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('username', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayNotHasKey('password', $data);
        $this->assertEquals('brice', $data['username']);
        $this->assertEquals('brice@nomail.com', $data['email']);
    }


    /**
     * Test of deleteUsersAction method
     */
    public function testDeleleUsersAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultDeleteTest($this->getUrl('delete_users', ['id' => $user1Id]));
    }

    /**
     * Test of postUsersAction method
     * @param array $user
     * @dataProvider userProvider
     */
    /*public function testPostUsersAction($user)
    {
        $response = $this->defaultPostTest($this->getUrl('post_users'), ['user' => $user]);

        // Check duplicate username validator
        $this->client->request('POST', $this->getUrl('post_users'), ['user' => $user]);
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }*/

    /**
     * Test of putUsersAction method
     * @param array $user
     * @dataProvider userProvider
     */
    /*public function testPutUsersAction($user)
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $response = $this->defaultPutTest($this->getUrl('put_users', ['id' => $user1Id]), ['user' => $user]);

        // Check update
        $this->client->request('GET', $this->getUrl('get_user', ['id' => $user1Id]));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertEquals($user['username'], $data['username']);
    }*/

    /**
     * User data provider
     * @return array
     */
    /*public function userProvider()
    {
        return [
            [['username' => 'tester_phpunit_1']],
            [['username' => 'tester_phpunit_2']],
        ];
    }*/
}
