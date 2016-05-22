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
 * Class PutSubTest
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
class PostPutSubTest implements SubTestInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $checkValues = [];

    /**
     * @param string $url
     * @param string $method POST or PUT
     * @param array $data
     */
    public function __construct(string $url, $method = 'POST', array $data = [])
    {
        if (!in_array($method, ['POST', 'PUT'])) {
            throw new \InvalidArgumentException(sprintf('Not authorized method %s (POST, PUT only)', $method));
        }

        $this->url = $url;
        $this->data = $data;
        $this->method = $method;
    }

    /**
     * Check values after put
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addCheckValue($key, $value)
    {
        $checkValues[$key] = $value;

        return $this;
    }

    /**
     * Test for authorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function authorizedTest(WebTestCase $webTestCase)
    {
        // Create
        $putResponse = $webTestCase->request($this->method, $this->url, $this->data);
        $webTestCase->assertEquals(20, substr($putResponse->getStatusCode(), 0, 2), $putResponse->getContent());

        $response = $webTestCase->request('GET', $this->url);
        $webTestCase->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $webTestCase->assertJson($response->getContent());

        // Check values
        if (count($this->checkValues)) {
            $data = json_decode($response->getContent(), true);
            foreach ($this->checkValues as $k => $v) {
                $this->assertEquals($v, $data[$k]);
            }
        }

        return $putResponse;
    }

    /**
     * Test for unauthorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function unauthorizedTest(WebTestCase $webTestCase)
    {
        $subTest = new UnauthorizedSubTest($this->url, $this->method, $this->data);
        return $subTest->unauthorizedTest($webTestCase);
    }
} 