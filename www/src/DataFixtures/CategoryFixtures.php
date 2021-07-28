<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{

    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $categories = [
            1 => [
                'name' => 'autre',
            ],
            2 => [
                'name' => 'anthropologie',
            ],
            3 => [
                'name' => 'histoire contemporaine',
            ],
            4 => [
                'name' => 'physique / chimie',
            ],
            5 => [
                'name' => 'astrophysique',
            ],
            6 => [
                'name' => 'science sociale',
            ],
            7 => [
                'name' => 'animaux',
            ],
            8 => [
                'name' => 'économie',
            ]
        ];

        for ($nbCategory = 1; $nbCategory <= count($categories); $nbCategory++) {
            $category = new Category();
            $category->setName($categories[$nbCategory]['name']);
            $this->addReference('category_' . $nbCategory, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
