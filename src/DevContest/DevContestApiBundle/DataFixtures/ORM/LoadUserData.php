<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 18:54
 */

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;

use DevContest\DevContestApiBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Users data fixtures
 * @package DevContest\DevContestApiBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Load users fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setNickname('brice');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setNickname('yoli');
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
}
