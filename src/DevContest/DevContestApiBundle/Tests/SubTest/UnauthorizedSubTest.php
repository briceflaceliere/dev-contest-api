<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 07/05/16
 * Time: 14:44
 */

namespace DevContest\DevContestApiBundle\Tests\SubTest;


use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UnauthorizedSubTest
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
class UnauthorizedSubTest implements SubTestInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param string $url
     * @param string $method
     * @param array $data
     */
    public function __construct(string $url, string $method = 'GET', array $data = [])
    {
        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
    }

    /**
     * Test for authorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function authorizedTest(WebTestCase $webTestCase)
    {
        throw new Exception('Not implemented method');
    }

    /**
     * Test for unauthorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function unauthorizedTest(WebTestCase $webTestCase)
    {
        $response = $webTestCase->request($this->method, $this->url, $this->data);
        $webTestCase->assertEquals(403, $response->getStatusCode(), $response->getContent());
        $webTestCase->assertJson($response->getContent());

        return $response;
    }
} 