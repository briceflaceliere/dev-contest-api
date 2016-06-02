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
        $ipsum = <<<'EOD'
Cras lobortis justo malesuada nunc consequat, a tincidunt leo tincidunt.
In nec suscipit ligula, eget lacinia massa. Morbi varius mauris sit amet tincidunt blandit.
Integer et eros metus. Aliquam erat volutpat. Mauris ut malesuada massa.
Aenean turpis neque, eleifend bibendum consectetur sed, vehicula et velit.
In ut nulla et diam euismod ornare nec ac libero.
Quisque a tortor ante. Ut tortor nulla, dictum at volutpat vel,
pulvinar ac lorem. Nam rutrum libero non aliquet commodo.
EOD;

        $data1 = new ContestStep();
        $data1->setContest($this->getReference('contest1'))
              ->setTitle('Step 1')
              ->setDescription($ipsum)
              ->setStatement($ipsum)
              ->setPosition(1);
        $manager->persist($data1);

        $data2 = new ContestStep();
        $data2->setContest($this->getReference('contest1'))
              ->setTitle('Step 2')
              ->setDescription($ipsum)
              ->setStatement($ipsum)
              ->setPosition(2);
        $manager->persist($data2);

        $manager->flush();

        $this->addReference('conteststep1', $data1);
        $this->addReference('conteststep2', $data2);
    }

    public function getDependencies()
    {
        return array('DevContest\DevContestApiBundle\DataFixtures\ORM\LoadContestData');
    }

}
