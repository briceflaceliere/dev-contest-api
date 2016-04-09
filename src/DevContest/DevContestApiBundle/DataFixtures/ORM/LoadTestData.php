<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 18:54
 */

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;

use DevContest\DevContestApiBundle\Entity\Test;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Tests data fixtures
 * @package DevContest\DevContestApiBundle\DataFixtures\ORM
 */
class LoadTestData extends AbstractFixture implements ContainerAwareInterface
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
     * Load tests fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tests = [
            [
                'title' => 'Test 1 : la vie des pingouins',
                'description' => 'Les pingouins sont de magnifiques petites créatures, pourvues d\'un nombril pour faire face aux coups durs.',
            ],
            [
                'title' => 'Test 2 : les bières, ça finit pas par terre',
                'description' => 'Toujours garder le goulot tête en haut, évite bien des sanglots. :( ',
            ],
        ];

        foreach ($tests as $i => $test) {
            $ref = new Test();
            $ref->setTitle($test['title']);
            $ref->setDescription($test['description']);

            $manager->persist($ref);

            $this->addReference('test'.($i+1), $ref);
        }

        $manager->flush();
    }
}
