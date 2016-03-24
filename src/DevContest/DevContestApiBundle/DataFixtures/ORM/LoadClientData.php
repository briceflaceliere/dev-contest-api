<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 18:54
 */

namespace DevContest\DevContestApiBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadClientData implements FixtureInterface, ContainerAwareInterface
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

    public function load(ObjectManager $manager)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('http://devcontest.perso.dev:8039/app_dev.php/'));
        $client->setAllowedGrantTypes(array('token', 'authorization_code'));
        $clientManager->updateClient($client);
    }
} 