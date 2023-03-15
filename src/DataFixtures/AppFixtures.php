<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Suite;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }


    private function generateName(): string
    {
        $adjectives = ['Luxueux', 'Moderne', 'Chic', 'Élégant', 'Confortable', 'Spacieux', 'Raffiné', 'Séduisant', 'Éblouissant', 'Exquis'];

        $adjective = $adjectives[array_rand($adjectives)];
        return "$adjective";
    }


    public function load(ObjectManager $manager)
    {
        $adjective = $this->generateName();
        $cities = ['Paris', 'Londres', 'New York', 'Tokyo', 'Barcelone', 'Dubai', 'Sydney', 'Rome', 'Amsterdam', 'Berlin'];
        $city = $cities[array_rand($cities)];
        // Créer les 5 établissements
        for ($i = 1; $i <= 5; $i++) {
            $etablissement = new Etablissement();
            $etablissement->setNom("Etablissement $adjective $i");
            $etablissement->setDescription("Description de l'établissement $i");
            $etablissement->setVille($city);
            $etablissement->setAdresse("Adresse de l'établissement $i");
            $manager->persist($etablissement);

            // Créer 20 suites pour chaque établissement
            for ($j = 1; $j <= 20; $j++) {
                $adjective = $this->generateName(); // ajout de la variable $adjective dans la boucle for
                $suite = new Suite();
                $suite->setTitre("Suite $adjective $j de l'établissement " . $etablissement->getNom());
                $suite->setDescription("Description de la suite $j de l'établissement $i");
                $suite->setPrix(100 + ($j % 5) * 50); // prix varie entre 100 et 250 euros
                $suite->setEtablissement($etablissement);
                $suite->setImageA('https://picsum.photos/200/300');
                $suite->setStatut('libre');
                $manager->persist($suite);
            }

            // Créer un gérant pour chaque établissement
            $gerant = new User();
            $gerant->setEmail("gerant$i@example.com");
            $gerant->setRoles(['ROLE_GERANT']);
            $gerant->setPassword('password');

            $manager->persist($gerant);
        }

        // Créer l'utilisateur de rôle "admin"
        $admin = new User();
        $admin->setEmail('fumetsuhanta@hotmail.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->userPasswordHasherInterface->hashPassword($admin, '280398'));

        $manager->persist($admin);

        $manager->flush();
    }
}
