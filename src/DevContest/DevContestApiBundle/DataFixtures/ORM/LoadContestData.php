<?php

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;

use DevContest\DevContestApiBundle\Entity\Contest;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadContestData
 * @package DevContest\DevContestApiBundle\DataFixtures
 */
class LoadContestData extends AbstractFixture implements ContainerAwareInterface, DependentFixtureInterface
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
     * Load Contest fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dateTime = new \DateTime();
        $dateTime->add(new \DateInterval('P1D'));

        $data1 = new Contest();
        $data1->setName('Contest 1')
              ->setStartTs($dateTime)
              ->addLanguage($this->getReference('languagePhp'))
              ->addLanguage($this->getReference('languageJs'));
        $manager->persist($data1);

        $data2 = new Contest();
        $data2->setName('Contest 2')
              ->addLanguage($this->getReference('languageJs'));
        $manager->persist($data2);

        $manager->flush();

        $this->addReference('contest1', $data1);
        $this->addReference('contest2', $data2);
    }

    public function getDependencies()
    {
        return array('DevContest\DevContestApiBundle\DataFixtures\ORM\LoadLanguageData');
    }

}
