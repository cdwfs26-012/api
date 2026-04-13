<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Client;
use App\Entity\Delivery;
use App\Entity\Product;
use App\Entity\Tour;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        $commonPassword = 'test';

        // --- 1. ADRESSES ---
        $adresses = [];
        $addrData = [
            ['street' => '12 rue de la Paix', 'city' => 'Chartres', 'zip' => '28000'],
            ['street' => '45 Avenue de la République', 'city' => 'Lucé', 'zip' => '28110'],
            ['street' => '8 Impasse des Lilas', 'city' => 'Mainvilliers', 'zip' => '28300'],
        ];

        foreach ($addrData as $data) {
            $addr = new Address();
            $addr->setStreet($data['street']);
            $addr->setCity($data['city']);
            $addr->setZipCode($data['zip']);
            $addr->setCountry('France');
            $manager->persist($addr);
            $adresses[] = $addr;
        }

        // --- 2. UTILISATEURS (ADMIN, CHAUFFEURS, CLIENTS) ---

        // Admin
        $admin = new User();
        $admin->setEmail('admin@legendre.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, $commonPassword));
        $manager->persist($admin);

        // Chauffeurs (Users avec propriétés Driver)
        $chauffeurs = [];
        $chauffeurData = [
            ['email' => 'jean@legendre.fr', 'fn' => 'Jean', 'ln' => 'Logistique'],
            ['email' => 'marc@legendre.fr', 'fn' => 'Marc', 'ln' => 'Express'],
            ['email' => 'lucie@legendre.fr', 'fn' => 'Lucie', 'ln' => 'Transport'],
        ];

        foreach ($chauffeurData as $data) {
            $u = new User();
            $u->setEmail($data['email']);
            $u->setFirstName($data['fn']);
            $u->setLastName($data['ln']);
            $u->setRoles(['ROLE_CHAUFFEUR']);
            $u->setPassword($this->hasher->hashPassword($u, $commonPassword));
            $manager->persist($u);
            $chauffeurs[] = $u;
        }

        // Client (User pour la sécurité)
        $userClient = new User();
        $userClient->setEmail('client@legendre.fr');
        $userClient->setRoles(['ROLE_CLIENT']);
        $userClient->setPassword($this->hasher->hashPassword($userClient, $commonPassword));
        $manager->persist($userClient);

        // --- 3. CLIENTS (ENTITÉ MÉTIER) ---
        $clients = [];
        $clientNames = [
            ['name' => 'Boulangerie Centrale', 'email' => 'contact@boulangerie.fr'],
            ['name' => 'Supermarché Express', 'email' => 'manager@express.fr'],
            ['name' => 'Restaurant du Port', 'email' => 'chef@duport.fr'],
        ];

        foreach ($clientNames as $data) {
            $c = new Client();
            $c->setName($data['name']);
            $c->setEmail($data['email']);
            $manager->persist($c);
            $clients[] = $c;
        }

        // --- 4. PRODUITS ---
        $products = [];
        $prodData = [
            ['name' => 'Farine 25kg', 'w' => 25.0],
            ['name' => 'Palette d\'eau', 'w' => 500.0],
            ['name' => 'Carton Surgelés', 'w' => 15.0],
        ];

        foreach ($prodData as $data) {
            $p = new Product();
            $p->setName($data['name']);
            $p->setWeight($data['w']);
            $manager->persist($p);
            $products[] = $p;
        }

        // --- 5. TOURNEES ---
        $tours = [];
        foreach ($chauffeurs as $index => $chauffeur) {
            $tour = new Tour();
            $tour->setReference('TOUR-2026-00' . ($index + 1));
            $tour->setDate(new \DateTimeImmutable());
            $tour->setDriver($chauffeur); // Liaison vers User (Chauffeur)
            $manager->persist($tour);
            $tours[] = $tour;
        }

        // --- 6. LIVRAISONS ---
        $statusOptions = ['PENDING', 'DELIVERED', 'CANCELLED'];
        for ($i = 0; $i < 6; $i++) {
            $delivery = new Delivery();
            $delivery->setPlannedAt(new \DateTimeImmutable('tomorrow +' . $i . ' hours'));
            $delivery->setStatus($statusOptions[array_rand($statusOptions)]);
            $delivery->setTour($tours[array_rand($tours)]);
            $delivery->setClient($clients[array_rand($clients)]);
            $delivery->setAddress($adresses[array_rand($adresses)]);
            $manager->persist($delivery);
        }

        $manager->flush();
    }
}
