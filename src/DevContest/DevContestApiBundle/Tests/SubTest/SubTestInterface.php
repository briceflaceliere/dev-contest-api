<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 07/05/16
 * Time: 14:54
 */

namespace DevContest\DevContestApiBundle\Tests\SubTest;


use DevContest\DevContestApiBundle\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface SubTestInterface
 * @package DevContest\DevContestApiBundle\Tests\SubTest
 */
interface SubTestInterface
{
    /**
     * Test for authorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function authorizedTest(WebTestCase $webTestCase);

    /**
     * Test for unauthorized test
     *
     * @param WebTestCase $webTestCase
     * @return Response
     */
    public function unauthorizedTest(WebTestCase $webTestCase);
} 