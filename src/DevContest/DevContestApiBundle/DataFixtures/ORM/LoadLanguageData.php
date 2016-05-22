<?php

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;

use DevContest\DevContestApiBundle\Entity\Language;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadLanguageData
 * @package DevContest\DevContestApiBundle\DataFixtures
 */
class LoadLanguageData extends AbstractFixture implements ContainerAwareInterface
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
     * Load Language fixtures
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data1 = new Language();
        $data1->setName('PHP')
              ->setLogo('php.png');
        $manager->persist($data1);

        $data2 = new Language();
        $data2->setName('Javascript');
        $manager->persist($data2);

        $manager->flush();

        $this->addReference('languagePhp', $data1);
        $this->addReference('languageJs', $data2);
    }
}
