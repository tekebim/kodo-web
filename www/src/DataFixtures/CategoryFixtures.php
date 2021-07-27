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
        $faker = Factory::create('fr_FR');

        for ($nbCat = 1; $nbCat < 20; $nbCat++) {
            $category = new Category();
            $category->setName($faker->word());
            $category->setSlug(strtolower($this->slugger->slug($category->getName())));
            $manager->persist($category);
        }

        $manager->flush();
    }
}
