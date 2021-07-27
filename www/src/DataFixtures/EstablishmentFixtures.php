<?php

namespace App\DataFixtures;

use App\Entity\Establishment;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EstablishmentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $owner = new Establishment();
        $owner->setName('kodoteam');
        $owner->setWebsite('https://www.kodotalks.com');
        $owner->setIsApproved(true);
        $manager->persist($owner);

        for ($count = 0; $count < 30; $count++) {
            $establishment = new Establishment();
            $establishment->setName($faker->company);
            $establishment->setWebsite($faker->url);
            $establishment->setIsApproved(true);
            $manager->persist($establishment);
            // Create conference for this establishment
            for ($c = 0; $c < 2; $c++) {
                $conference = new Conference();
                $conference->setName($faker->company)
                    ->setLocation($faker->streetAddress)
                    ->setAuthor($faker->name)
                    ->setSpeakers($faker->name)
                    ->setLikes(mt_rand(0,100))
                    ->setDate($faker->dateTimeBetween('-10 days', '+90 days'))
                    ->setExtract($faker->text)
                    ->setDescription($faker->text)
                    ->setEstablishment($establishment)
                    ->setUrl($faker->url);

                $manager->persist($conference);
            }
        }

        $manager->flush();
    }
}
