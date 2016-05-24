<?php

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;

use DevContest\DevContestApiBundle\Entity\ContestStep;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadContestStepData
 * @package DevContest\DevContestApiBundle\DataFixtures
 */
class LoadContestStepData extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
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
     * Load ContestStep fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data1 = new ContestStep();
        $data1->setTest($this->getReference('test1'))
              ->setContest($this->getReference('contest1'));
        $manager->persist($data1);

        $data2 = new ContestStep();
        $data2->setTest($this->getReference('test2'))
              ->setContest($this->getReference('contest1'))
              ->setPreviousContestStep($data1);
        $manager->persist($data2);

        $manager->flush();

        $this->addReference('conteststep1', $data1);
        $this->addReference('conteststep2', $data2);
    }

    public function getDependencies()
    {
        return array('DevContest\DevContestApiBundle\DataFixtures\ORM\LoadContestData',
                     'DevContest\DevContestApiBundle\DataFixtures\ORM\LoadTestData');
    }
}
