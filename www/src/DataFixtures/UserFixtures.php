<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        // $faker->addProvider();

        $user = new User();
        $user->setName('dev');
        $user->setEmail('dev@localhost.com');
        $user->setRoles(["ROLE_ADMIN"]);
        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);
        // $user->setEstablishment();
        $manager->persist($user);

        for ($count = 0; $count < 10; $count++) {
            $user = new User();
            $user->setName($faker->name);
            $user->setEmail($faker->email);
            $user->setRoles(["ROLE_USER"]);
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
