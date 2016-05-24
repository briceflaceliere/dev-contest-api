<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;
use DevContest\DevContestApiBundle\Tests\SubTest\DeleteSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\GetSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PaginatorSubTest;
use DevContest\DevContestApiBundle\Tests\SubTest\PostPutSubTest;

/**
 * Class tests the ContestStepController
 * @package DevContest\DevContestApiBundle\Tests\Controller
 */
class ContestStepControllerTest extends WebTestCase
{

    protected $loadFixtures = [
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadUserData',
        'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadContestStepData',
    ];

    /**
     * Test of getContestStepsAction method
     */
    public function testGetContestStepsAction()
    {
        $subTest = new PaginatorSubTest($this->getUrl('get_conteststeps'));
        $subTest->setItemsNotEmpty(true);
        // $subTest->setItemKeys(['id', 'username']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of getContestStepAction method
     */
    public function testGetContestStepAction()
    {
        $conteststep1Id = $this->fixtures->getReference('conteststep1')->getId();

        $subTest = new GetSubTest($this->getUrl('get_conteststep', ['id' => $conteststep1Id]));
        // $subTest->setItemKeys(['id', 'username']);
        $this->aclTest($subTest, [null, 'user1', 'api', 'engine', 'admin'], []);
    }

    /**
     * Test of deleleContestStepsAction method
     */
    public function testDeleleContestStepsAction()
    {
        $conteststep1Id = $this->fixtures->getReference('conteststep1')->getId();

        $subTest = new DeleteSubTest($this->getUrl('delete_conteststeps', ['id' => $conteststep1Id]));
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of post$ContestStepAction method
     *
     * @param array $conteststep
     * @dataProvider conteststepProvider
     */
    public function testPostContestStepsAction($conteststep)
    {
        $subTest = new PostPutSubTest($this->getUrl('post_conteststeps'), 'POST', ['conteststep' => $conteststep]);
        //$subTest->addCheckValue('title', $conteststep['title']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * Test of put$ContestStepAction method
     *
     * @param array $conteststep
     * @dataProvider conteststepProvider
     */
    public function testPutContestStepsAction($conteststep)
    {
        $conteststep1Id = $this->fixtures->getReference('conteststep1')->getId();

        $subTest = new PostPutSubTest($this->getUrl('put_conteststeps', ['id' => $conteststep1Id]), 'PUT', ['conteststep' => $conteststep]);
        //$subTest->addCheckValue('title', $conteststep['title']);
        $this->aclTest($subTest, ['admin'], [null, 'user1', 'api', 'engine']);
    }

    /**
     * ContestStep data provider
     * @return array
     */
    public function conteststepProvider()
    {
        return [];
    }
}
