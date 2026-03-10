<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\DataFixtures\AppFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupération des catégories via les références
        $categories = [
            $this->getReference('category_action'),
            $this->getReference('category_aventure'),
            $this->getReference('category_rpg'),
            $this->getReference('category_sport'),
        ];

        // Tableau de base de jeux
        $games = [
            ['Super Action', 49.99, 'Un jeu d’action palpitant'],
            ['Action Extrême', 39.99, 'Toujours plus d’action'],
            ['Aventure Mystérieuse', 45.50, 'Explorez des mondes inconnus'],
            ['Aventure Fantastique', 52.00, 'Quêtes et magie'],
            ['RPG Légendaire', 60.00, 'Un RPG épique avec beaucoup de quêtes'],
            ['RPG Mystique', 55.50, 'Plongez dans un monde mystique'],
            ['Sport Pro', 40.00, 'Simulation de sport réaliste'],
            ['Sport Champion', 42.00, 'Deuxième édition améliorée'],
            ['Sport Ultimate', 44.00, 'Nouvelle saison et nouveaux joueurs'],
        ];

        for ($i = 0; $i < 50; $i++) {
            $gameData = $games[$i % count($games)]; // boucle sur le tableau si moins de 50
            $product = new Product();
            $product->setName($gameData[0] . " #" . ($i + 1))
                    ->setPrice((string)$gameData[1])
                    ->setDescription($gameData[2])
                    ->setStock(random_int(10, 100))
                    ->setActive(true)
                    ->setCategory($categories[$i % count($categories)])
                    ->setPlatform(['PC', 'PS5', 'Xbox'][random_int(0,2)])
                    ->setReleaseYear(random_int(2000, 2026))
                    ->setImage(null); // tu peux mettre une URL ou chemin d'image ici

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}