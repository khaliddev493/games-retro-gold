<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $products = [

            // ── NES (4 jeux) ────────────────────────────────────────────────
            [
                'name'        => 'Super Mario Bros.',
                'description' => 'Le jeu de plateforme qui a révolutionné le monde du jeu vidéo. Mario doit sauver la Princesse Peach.',
                'price'       => '29.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6cl1.jpg',
                'platform'    => 'NES',
                'releaseYear' => 1985,
                'stock'       => 10,
                'category'    => CategoryFixtures::CATEGORY_NES,
            ],
            [
                'name'        => 'The Legend of Zelda',
                'description' => 'L\'aventure épique de Link dans le monde d\'Hyrule. Un RPG d\'action fondateur.',
                'price'       => '34.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6cl3.jpg',
                'platform'    => 'NES',
                'releaseYear' => 1986,
                'stock'       => 7,
                'category'    => CategoryFixtures::CATEGORY_NES,
            ],
            [
                'name'        => 'Mega Man 2',
                'description' => 'Le meilleur opus de la série Mega Man. Des niveaux mythiques et une OST inoubliable.',
                'price'       => '24.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xwn.jpg',
                'platform'    => 'NES',
                'releaseYear' => 1988,
                'stock'       => 5,
                'category'    => CategoryFixtures::CATEGORY_NES,
            ],
            [
                'name'        => 'Contra',
                'description' => 'Le shoot\'em up de référence sur NES. Deux soldats contre une armée d\'extraterrestres.',
                'price'       => '22.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1ywt.jpg',
                'platform'    => 'NES',
                'releaseYear' => 1988,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_NES,
            ],

            // ── SNES (4 jeux) ───────────────────────────────────────────────
            [
                'name'        => 'Super Mario World',
                'description' => 'Mario et Yoshi explorent Dinosaur Land. Le jeu de lancement de la Super Nintendo.',
                'price'       => '39.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6cl9.jpg',
                'platform'    => 'SNES',
                'releaseYear' => 1990,
                'stock'       => 8,
                'category'    => CategoryFixtures::CATEGORY_SNES,
            ],
            [
                'name'        => 'Street Fighter II Turbo',
                'description' => 'Le jeu de combat légendaire avec tous les personnages et les modes de jeu.',
                'price'       => '44.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1ymq.jpg',
                'platform'    => 'SNES',
                'releaseYear' => 1993,
                'stock'       => 4,
                'category'    => CategoryFixtures::CATEGORY_SNES,
            ],
            [
                'name'        => 'Donkey Kong Country',
                'description' => 'Les graphismes pré-rendus révolutionnaires de Rare. DK et Diddy contre King K. Rool.',
                'price'       => '37.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xnq.jpg',
                'platform'    => 'SNES',
                'releaseYear' => 1994,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_SNES,
            ],
            [
                'name'        => 'Super Metroid',
                'description' => 'Samus Aran explore la planète Zebes. Un chef-d\'oeuvre de l\'exploration et de l\'atmosphère.',
                'price'       => '49.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co633p.jpg',
                'platform'    => 'SNES',
                'releaseYear' => 1994,
                'stock'       => 3,
                'category'    => CategoryFixtures::CATEGORY_SNES,
            ],

            // ── MEGA DRIVE (4 jeux) ─────────────────────────────────────────
            [
                'name'        => 'Sonic the Hedgehog',
                'description' => 'Le hérisson bleu de Sega dans son premier jeu de vitesse époustouflant.',
                'price'       => '29.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xm9.jpg',
                'platform'    => 'Mega Drive',
                'releaseYear' => 1991,
                'stock'       => 9,
                'category'    => CategoryFixtures::CATEGORY_MEGADRIVE,
            ],
            [
                'name'        => 'Streets of Rage 2',
                'description' => 'Le meilleur beat\'em up de la Mega Drive avec une OST mythique signée Yuzo Koshiro.',
                'price'       => '32.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1rqq.jpg',
                'platform'    => 'Mega Drive',
                'releaseYear' => 1992,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_MEGADRIVE,
            ],
            [
                'name'        => 'Mortal Kombat',
                'description' => 'Le jeu de combat controversé avec son célèbre système de Fatality. Version avec le sang !',
                'price'       => '27.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1wy0.jpg',
                'platform'    => 'Mega Drive',
                'releaseYear' => 1993,
                'stock'       => 3,
                'category'    => CategoryFixtures::CATEGORY_MEGADRIVE,
            ],
            [
                'name'        => 'Gunstar Heroes',
                'description' => 'Un run and gun frénétique de Treasure. L\'un des jeux d\'action les plus intenses de la Mega Drive.',
                'price'       => '35.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xpe.jpg',
                'platform'    => 'Mega Drive',
                'releaseYear' => 1993,
                'stock'       => 4,
                'category'    => CategoryFixtures::CATEGORY_MEGADRIVE,
            ],

            // ── GAME BOY (4 jeux) ───────────────────────────────────────────
            [
                'name'        => 'Tetris',
                'description' => 'Le puzzle game addictif qui a accompagné la Game Boy dès son lancement mondial.',
                'price'       => '19.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2fo9.jpg',
                'platform'    => 'Game Boy',
                'releaseYear' => 1989,
                'stock'       => 15,
                'category'    => CategoryFixtures::CATEGORY_GAMEBOY,
            ],
            [
                'name'        => 'Pokémon Rouge',
                'description' => 'Attrapez-les tous ! Le RPG qui a lancé la saga Pokémon avec 151 créatures.',
                'price'       => '49.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1yw3.jpg',
                'platform'    => 'Game Boy',
                'releaseYear' => 1996,
                'stock'       => 5,
                'category'    => CategoryFixtures::CATEGORY_GAMEBOY,
            ],
            [
                'name'        => 'The Legend of Zelda : Link\'s Awakening',
                'description' => 'Link échoue sur l\'île Cocolint. Un Zelda portable magnifique et mystérieux.',
                'price'       => '39.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6dh0.jpg',
                'platform'    => 'Game Boy',
                'releaseYear' => 1993,
                'stock'       => 7,
                'category'    => CategoryFixtures::CATEGORY_GAMEBOY,
            ],
            [
                'name'        => 'Kirby\'s Dream Land',
                'description' => 'Le premier jeu de Kirby ! Une aventure courte mais charmante sur Game Boy.',
                'price'       => '18.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2d.jpg',
                'platform'    => 'Game Boy',
                'releaseYear' => 1992,
                'stock'       => 8,
                'category'    => CategoryFixtures::CATEGORY_GAMEBOY,
            ],

            // ── ARCADE (4 jeux) ─────────────────────────────────────────────
            [
                'name'        => 'Pac-Man',
                'description' => 'Le classique absolu des salles d\'arcade. Mangez les pac-gommes, évitez les fantômes !',
                'price'       => '14.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6624.jpg',
                'platform'    => 'Arcade',
                'releaseYear' => 1980,
                'stock'       => 20,
                'category'    => CategoryFixtures::CATEGORY_ARCADE,
            ],
            [
                'name'        => 'Space Invaders',
                'description' => 'Défendez la Terre contre l\'invasion extraterrestre dans ce shoot\'em up fondateur.',
                'price'       => '12.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co6dh5.jpg',
                'platform'    => 'Arcade',
                'releaseYear' => 1978,
                'stock'       => 18,
                'category'    => CategoryFixtures::CATEGORY_ARCADE,
            ],
            [
                'name'        => 'Donkey Kong',
                'description' => 'La borne arcade originale avec Mario (alors Jumpman) qui grimpe pour sauver Pauline.',
                'price'       => '16.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1ywu.jpg',
                'platform'    => 'Arcade',
                'releaseYear' => 1981,
                'stock'       => 12,
                'category'    => CategoryFixtures::CATEGORY_ARCADE,
            ],
            [
                'name'        => 'Galaga',
                'description' => 'Le shoot\'em up de Namco où les ennemis piquent en formation. Un classique intemporel.',
                'price'       => '13.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co4a7b.jpg',
                'platform'    => 'Arcade',
                'releaseYear' => 1981,
                'stock'       => 14,
                'category'    => CategoryFixtures::CATEGORY_ARCADE,
            ],

            // ── MASTER SYSTEM (3 jeux) ──────────────────────────────────────
            [
                'name'        => 'Alex Kidd in Miracle World',
                'description' => 'La mascotte de Sega avant Sonic ! Un jeu de plateforme intégré dans la console.',
                'price'       => '21.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2f.jpg',
                'platform'    => 'Master System',
                'releaseYear' => 1986,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_MASTER,
            ],
            [
                'name'        => 'Phantasy Star',
                'description' => 'Le premier RPG de science-fiction de Sega. Une héroïne, un monde futuriste, une épopée.',
                'price'       => '28.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3wh8.jpg',
                'platform'    => 'Master System',
                'releaseYear' => 1987,
                'stock'       => 4,
                'category'    => CategoryFixtures::CATEGORY_MASTER,
            ],
            [
                'name'        => 'Wonder Boy III',
                'description' => 'Un action-RPG sur Master System avec différentes formes de personnage à débloquer.',
                'price'       => '25.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co3p2g.jpg',
                'platform'    => 'Master System',
                'releaseYear' => 1989,
                'stock'       => 5,
                'category'    => CategoryFixtures::CATEGORY_MASTER,
            ],

            // ── NINTENDO 64 (4 jeux) ────────────────────────────────────────
            [
                'name'        => 'Mario Kart 64',
                'description' => 'Les courses de kart en 3D avec Mario et ses amis. Le jeu de fête par excellence sur N64.',
                'price'       => '47.99',
                'imageUrl'    => 'https://www.nintendo.com/eu/media/images/10_share_images/games_15/nintendo_7/H2x1_N64_MarioKart64_image1600w.jpg',
                'platform'    => 'Nintendo 64',
                'releaseYear' => 1996,
                'stock'       => 7,
                'category'    => CategoryFixtures::CATEGORY_N64,
            ],
            [
                'name'        => 'Super Mario 64',
                'description' => 'Le premier Mario en 3D. Une révolution absolue qui a défini le jeu de plateforme moderne.',
                'price'       => '54.99',
                'imageUrl'    => 'https://www.nintendo.com/eu/media/images/10_share_images/games_15/nintendo_7/SI_N64_SuperMario64_image1600w.jpg',
                'platform'    => 'Nintendo 64',
                'releaseYear' => 1996,
                'stock'       => 8,
                'category'    => CategoryFixtures::CATEGORY_N64,
            ],
            [
                'name'        => 'The Legend of Zelda : Ocarina of Time',
                'description' => 'Souvent élu meilleur jeu de tous les temps. Link voyage dans le temps pour sauver Hyrule.',
                'price'       => '59.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co5vmg.jpg',
                'platform'    => 'Nintendo 64',
                'releaseYear' => 1998,
                'stock'       => 5,
                'category'    => CategoryFixtures::CATEGORY_N64,
            ],
            [
                'name'        => 'GoldenEye 007',
                'description' => 'Le FPS multijoueur qui a révolutionné les soirées entre amis. Basé sur le film de James Bond.',
                'price'       => '44.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co2vpm.jpg',
                'platform'    => 'Nintendo 64',
                'releaseYear' => 1997,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_N64,
            ],
            

            // ── PLAYSTATION 1 (3 jeux) ──────────────────────────────────────
            [
                'name'        => 'Final Fantasy VII',
                'description' => 'Le RPG qui a conquis l\'Occident. Cloud Strife affronte Sephiroth dans un monde cyberpunk.',
                'price'       => '64.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co7uho.jpg',
                'platform'    => 'PlayStation 1',
                'releaseYear' => 1997,
                'stock'       => 4,
                'category'    => CategoryFixtures::CATEGORY_PS1,
            ],
            [
                'name'        => 'Crash Bandicoot',
                'description' => 'Le bandicoot orange de Naughty Dog. La réponse de Sony à Mario sur PlayStation.',
                'price'       => '34.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xk8.jpg',
                'platform'    => 'PlayStation 1',
                'releaseYear' => 1996,
                'stock'       => 9,
                'category'    => CategoryFixtures::CATEGORY_PS1,
            ],
            [
                'name'        => 'Tekken 3',
                'description' => 'Le meilleur jeu de combat 3D de la PS1. Jin Kazama fait ses débuts dans la série.',
                'price'       => '39.99',
                'imageUrl'    => 'https://images.igdb.com/igdb/image/upload/t_cover_big/co1xmb.jpg',
                'platform'    => 'PlayStation 1',
                'releaseYear' => 1998,
                'stock'       => 6,
                'category'    => CategoryFixtures::CATEGORY_PS1,
            ],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setImageUrl($data['imageUrl']);
            $product->setPlatform($data['platform']);
            $product->setReleaseYear($data['releaseYear']);
            $product->setStock($data['stock']);

            /** @var \App\Entity\Category $category */
            $category = $this->getReference($data['category'], Category::class);
            $product->setCategory($category);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}