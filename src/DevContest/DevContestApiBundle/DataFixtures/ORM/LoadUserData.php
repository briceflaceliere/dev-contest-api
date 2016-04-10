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
        $encoder = $this->container->get('security.password_encoder');

        $user1 = new User();
        $user1->setUsername('brice');
        $user1->setEmail('brice@nomail.com');
        $encoded = $encoder->encodePassword($user1, 'bricepwd');
        $user1->setPassword($encoded);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('yoli');
        $user2->setEmail('yoli@nomail.com');
        $encoded = $encoder->encodePassword($user2, 'yolipwd');
        $user2->setPassword($encoded);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
}
