<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    // ── Constantes de référence ──────────────────────────────────────────────
    public const CATEGORY_NES       = 'category-nes';
    public const CATEGORY_SNES      = 'category-snes';
    public const CATEGORY_MEGADRIVE = 'category-megadrive';
    public const CATEGORY_GAMEBOY   = 'category-gameboy';
    public const CATEGORY_ARCADE    = 'category-arcade';
    public const CATEGORY_MASTER    = 'category-master';
    public const CATEGORY_N64       = 'category-n64';
    public const CATEGORY_PS1       = 'category-ps1';

    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::CATEGORY_NES => [
                'name'        => 'Nintendo NES',
                'description' => 'Jeux pour la Nintendo Entertainment System, la console 8 bits légendaire de 1983.',
            ],
            self::CATEGORY_SNES => [
                'name'        => 'Super Nintendo (SNES)',
                'description' => 'Jeux pour la Super Nintendo, la 16 bits de Nintendo sortie en 1990.',
            ],
            self::CATEGORY_MEGADRIVE => [
                'name'        => 'Sega Mega Drive',
                'description' => 'Jeux pour la Mega Drive, la rivale 16 bits de Sega sortie en 1988.',
            ],
            self::CATEGORY_GAMEBOY => [
                'name'        => 'Game Boy',
                'description' => 'Jeux pour la Game Boy et Game Boy Color, la portable de Nintendo (1989).',
            ],
            self::CATEGORY_ARCADE => [
                'name'        => 'Bornes Arcade',
                'description' => 'Portages des grands classiques des salles d\'arcade des années 80 et 90.',
            ],
            self::CATEGORY_MASTER => [
                'name'        => 'Sega Master System',
                'description' => 'Jeux pour la Master System, la console 8 bits de Sega sortie en 1985.',
            ],
            self::CATEGORY_N64 => [
                'name'        => 'Nintendo 64',
                'description' => 'Jeux pour la Nintendo 64, la première console 3D de Nintendo (1996).',
            ],
            self::CATEGORY_PS1 => [
                'name'        => 'PlayStation 1',
                'description' => 'Jeux pour la première PlayStation de Sony, sortie en 1994.',
            ],
        ];

        foreach ($categories as $reference => $data) {
            $category = new Category();
            $category->setName($data['name']);
            $category->setDescription($data['description']);

            $manager->persist($category);
            $this->addReference($reference, $category);
        }

        $manager->flush();
    }
}
