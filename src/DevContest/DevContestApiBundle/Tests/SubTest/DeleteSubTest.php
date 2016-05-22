<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 07/05/16
 * Time: 14:44
 */

namespace DevContest\DevContestApiBundle\Tests\SubTest;


use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteSubTest
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
class DeleteSubTest implements SubTestInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Test for authorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function authorizedTest(WebTestCase $webTestCase)
    {
        // Delete
        $deleteResponse = $webTestCase->request('DELETE', $this->url);
        $webTestCase->assertEquals(204, $deleteResponse->getStatusCode(), $deleteResponse->getContent());

        // Check not exist
        $response = $webTestCase->request('HEAD', $this->url);
        $webTestCase->assertGreaterThanOrEqual(403, $response->getStatusCode(), $response->getContent());
        $webTestCase->assertLessThanOrEqual(404, $response->getStatusCode(), $response->getContent());

        return $deleteResponse;
    }

    /**
     * Test for unauthorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function unauthorizedTest(WebTestCase $webTestCase)
    {
        $subTest = new UnauthorizedSubTest($this->url, 'DELETE');
        return $subTest->unauthorizedTest($webTestCase);
    }


} 