<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthorizationTest extends WebTestCase
{
    public function testСheckingСurrentAuthenticationKey()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            '/projects/1',
            array(),
            array(),
            array(
                'CONTENT_TYPE'          => 'application/json',
                'HTTP_REFERER'          => '/foo/bar',
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
                'HTTP_AUTHORIZATION'    => 'b6d767d2f8ed5d21a44b0e5886680cb',
            )
        );

        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode(),
            'The Authorization key "b6d767d2f8ed5d21a44b0e5886680cb" is deprecated'
        );
    }
}
