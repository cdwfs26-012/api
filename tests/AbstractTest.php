<?php
namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

abstract class AbstractTest extends ApiTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }
    protected function createAuthenticatedClient(string $email, string $password = 'test')
    {
        $client = static::createClient();

        $response = $client->request('POST', '/auth', [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        $data = $response->toArray();

        return static::createClient([], [
            'headers' => [
                'Authorization' => 'Bearer ' . $data['token'],
                'Content-Type' => 'application/json',
            ],
        ]);
    }
}
