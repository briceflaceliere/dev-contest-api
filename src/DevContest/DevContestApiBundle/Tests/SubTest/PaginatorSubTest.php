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
 * Class PaginatorSubTest
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
class PaginatorSubTest implements SubTestInterface
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var bool
     */
    protected $itemsNotEmpty = false;

    /**
     * @var array
     */
    protected $itemsKeys;

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Check if array items is not empty
     *
     * @param bool $notEmpty
     * @return $this
     */
    public function setItemsNotEmpty(bool $notEmpty)
    {
        $this->itemsNotEmpty = $notEmpty;

        return $this;
    }

    /**
     * @param array $keys
     * @return $this
     */
    public function setItemsKeys(array $keys)
    {
        $this->itemsKeys = $keys;

        return $this;
    }

    /**
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function authorizedTest(WebTestCase $webTestCase)
    {
        $response = $webTestCase->request('GET', $this->url);
        $webTestCase->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $webTestCase->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->testPagination($webTestCase, $data);

        if ($this->itemsNotEmpty) {
            $webTestCase->assertGreaterThan(0, count($data['items']));
        }

        if (is_array($this->itemsKeys)) {
            foreach ($data['items'] as $item) {
                $webTestCase->assertEquals($this->itemsKeys, array_keys($item));
            }
        }

        return $response;
    }

    /**
     * @param WebTestCase $webTestCase
     * @param array $data
     */
    protected function testPagination(WebTestCase $webTestCase, array $data)
    {
        $webTestCase->assertArrayHasKey('page', $data);
        $webTestCase->assertArrayHasKey('limit', $data);
        $webTestCase->assertArrayHasKey('items', $data);
        $webTestCase->assertTrue(is_array($data['items']));
        $webTestCase->assertArrayHasKey('total_items', $data);
        $webTestCase->assertArrayHasKey('total_pages', $data);
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