<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 03/04/16
 * Time: 15:42
 */

namespace DevContest\DevContestApiBundle\Tests;

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
     * Default check for get list action
     *
     * @param string $url
     * @return Response
     */
    protected function defaultGetListTest($url)
    {
        $this->client->request('GET', $url);

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('page', $data);
        $this->assertArrayHasKey('limit', $data);
        $this->assertArrayHasKey('items', $data);
        $this->assertTrue(is_array($data['items']));
        $this->assertArrayHasKey('total_items', $data);
        $this->assertArrayHasKey('total_pages', $data);

        return $response;
    }

    /**
     * Default check for get action
     *
     * @param string $url
     * @return Response
     */
    protected function defaultGetTest($url)
    {
        $this->client->request('GET', $url);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $this->assertJson($response->getContent());

        return $response;
    }

    /**
     * Default check for delete action
     *
     * @param string $url
     * @return Response
     */
    protected function defaultDeleteTest($url)
    {

        // Check exist
        $this->client->request('HEAD', $url);
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        // Delete
        $this->client->request('DELETE', $url);
        $deleteResponse = $this->client->getResponse();
        $this->assertEquals(204, $deleteResponse->getStatusCode(), $deleteResponse->getContent());

        // Check not exist
        $this->client->request('HEAD', $url);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode(), $response->getContent());

        return $deleteResponse;
    }

    /**
     * Default check for post action
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    protected function defaultPostTest($url, $data)
    {
        // Create
        $this->client->request('POST', $url, $data);
        $postResponse = $this->client->getResponse();
        $this->assertEquals(201, $postResponse->getStatusCode(), $postResponse->getContent());
        $this->assertNotEmpty($postResponse->headers->get('Location'));

        // Check create
        $this->client->request('HEAD', $postResponse->headers->get('Location'));
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());

        return $postResponse;
    }

    /**
     * Default check for put action
     *
     * @param string $url
     * @param array $data
     * @return Response
     */
    protected function defaultPutTest($url, $data)
    {
        $this->client->request('PUT', $url, $data);
        $response = $this->client->getResponse();
        $this->assertEquals(204, $response->getStatusCode(), $response->getContent());

        return $response;
    }
}
