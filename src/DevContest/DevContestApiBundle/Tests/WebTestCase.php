<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 03/04/16
 * Time: 15:42
 */

namespace DevContest\DevContestApiBundle\Tests;

use DevContest\DevContestApiBundle\Entity\User;
use DevContest\DevContestApiBundle\Tests\SubTest\SubTestInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Liip\FunctionalTestBundle\Test\WebTestCase as ParentWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WebTestCase
 * @package DevContest\DevContestApiBundle\Tests
 */
class WebTestCase extends ParentWebTestCase
{
    protected $loadFixtures = [];

    protected $fixtures;

    protected $client;

    protected $connectedUser;

    protected $headers = [];

    protected $tmpAuthorization;

    /**
     * @inheritdoc
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function setUp()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        if (!isset($metadatas)) {
            $metadatas = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();

        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
        $this->postFixtureSetup();

        $this->fixtures = $this->loadFixtures($this->loadFixtures)->getReferenceRepository();

        $this->client = static::createClient();
    }


    /**
     * @param SubTestInterface $subTest
     * @param array $authorisedUsers List of authorized users (fixtureReference, null for disconnect users)
     * @param array $unauthorizedUsers  List of unauthorized users (fixtureReference, null for disconnect users)
     * @return Response
     * @throws \Exception
     */
    public function aclTest(SubTestInterface $subTest, array $authorisedUsers = [null], array $unauthorizedUsers = [])
    {
        $this->tmpAuthorization = $this->headers['HTTP_Authorization']; //save authorization

        foreach ($unauthorizedUsers as $userRef) {
            $this->disconnectUser();
            if ($userRef != null && $user = $this->fixtures->getReference($userRef)) {
                if (!$user instanceof User) {
                    throw new \Exception($userRef . ' is not user fixture reference');
                }
                $this->connectUser($user);
            }
            $subTest->unauthorizedTest($this);
        }

        //Authorized users
        foreach ($authorisedUsers as $userRef) {
            $this->setUp();
            $this->disconnectUser();
            if ($userRef != null && $user = $this->fixtures->getReference($userRef)) {
                if (!$user instanceof User) {
                    throw new \Exception($userRef . ' is not user fixture reference');
                }
                $this->connectUser($user);
            }
            $subTest->authorizedTest($this);
        }

        $this->headers['HTTP_Authorization'] = $this->tmpAuthorization; //restore authorization
    }

    /**
     * Connect user for test
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function connectUser(User $user)
    {
        if (!$jwtToken = $this->getContainer()->get('jwt_auth.auth0_service')->encodeJWT($user->getJwtPayload())) {
            throw new \Exception('Unable to generate a jwt token');
        }

        $this->connectedUser = $user;
        $this->headers['HTTP_Authorization'] = sprintf('Bearer %s', $jwtToken);
    }

    /**
     * Disconnect user for test
     *
     * @return bool
     */
    public function disconnectUser()
    {
        if (isset($this->headers['HTTP_Authorization'])) {
            unset($this->headers['HTTP_Authorization']);
            $this->connectedUser = null;
            return true;
        }

        return false;
    }

    /**
     * Get connected user
     *
     * @return User|null
     */
    public function getConnectedUser()
    {
        return $this->connectedUser;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $data
     * @return Response
     */
    public function request($method, $url, array $data = [])
    {
        $this->client->request($method, $url, $data, [], $this->headers);
        return $this->client->getResponse();
    }

}
