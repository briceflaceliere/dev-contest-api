<?php

namespace DevContest\DevContestApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUsersAction()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('page', $data);
        $this->assertArrayHasKey('limit', $data);
        $this->assertArrayHasKey('items', $data);
        $this->assertTrue(is_array($data['items']));
        $this->assertArrayHasKey('total_items', $data);
        $this->assertArrayHasKey('total_pages', $data);

        return 'test1';
    }

}
