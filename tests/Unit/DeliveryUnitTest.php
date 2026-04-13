<?php

namespace App\Tests\Unit;

use App\Entity\Delivery;
use PHPUnit\Framework\TestCase;

class DeliveryUnitTest extends TestCase
{
    public function testDeliveryEntityState(): void
    {
        // 1. Instanciation de l'entité
        $delivery = new Delivery();

        // 2. Définition d'un statut
        $status = 'pending';
        $delivery->setStatus($status);

        // 3. Vérification (Assertion)
        $this->assertEquals($status, $delivery->getStatus());
    }
}
