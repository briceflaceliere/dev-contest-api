<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\SubTest\DeleteSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\GetSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PaginatorSubTest;
use DevContest\DevContestApiBundle\Tests\WebTestCase;

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
        $subTest = new PaginatorSubTest($this->getUrl('get_users'));
        $subTest->setItemsNotEmpty(true)
                ->setItemsKeys(['id', 'username']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'admin'], []);
    }

    /**
     * Test of getUserAction method
     */
    public function testGetUserAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $subTest = new GetSubTest($this->getUrl('get_user', ['id' => $user1Id]));
        $subTest->setItemKeys(['id', 'username']);
        $this->aclTest($subTest, [null, 'user1', 'user2', 'api', 'admin'], []);
    }

    /**
     * Test of getUserPrivateAction method
     */
    public function testGetUserPrivateAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $subTest = new GetSubTest($this->getUrl('get_user_private', ['id' => $user1Id]));
        $subTest->setItemKeys(['id', 'username', 'email']);
        $this->aclTest($subTest, ['user1', 'api', 'admin'], [null, 'user2']);
    }


    /**
     * Test of deleteUsersAction method
     */
    public function testDeleleUsersAction()
    {
        $user1Id = $this->fixtures->getReference('user1')->getId();

        $subTest = new DeleteSubTest($this->getUrl('delete_users', ['id' => $user1Id]));
        $this->aclTest($subTest, ['user1', 'api', 'admin'], [null, 'user2']);
    }


}
