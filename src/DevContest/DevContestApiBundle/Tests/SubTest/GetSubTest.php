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
 * Class GetSubTest
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
class GetSubTest implements SubTestInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $itemKeys;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Check keys of item
     *
     * @param array $keys
     * @return $this
     */
    public function setItemKeys(array $keys)
    {
        $this->itemKeys = $keys;

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
        $response = $webTestCase->request('GET', $this->url);
        $webTestCase->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $webTestCase->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        if (is_array($this->itemKeys)) {
            $webTestCase->assertEquals($this->itemKeys, array_keys($data));
        }

        return $response;
    }

    /**
     * Test for unauthorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function unauthorizedTest(WebTestCase $webTestCase)
    {
        $subTest = new UnauthorizedSubTest($this->url, 'GET');
        return $subTest->unauthorizedTest($webTestCase);
    }
} 