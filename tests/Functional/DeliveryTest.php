<?php
namespace App\Tests\Functional;

use App\Tests\AbstractTest;

class DeliveryTest extends AbstractTest
{
    public function testAdminCanSeeAllDeliveries(): void
    {
        // On utilise la méthode créée dans AbstractTest
        $client = $this->createAuthenticatedClient('admin@legendre.fr');

        $client->request('GET', '/api/deliveries');

        $this->assertResponseIsSuccessful();
    }


}
