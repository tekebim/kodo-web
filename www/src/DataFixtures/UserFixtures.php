<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
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

        for ($nbAccount = 1; $nbAccount < 10; $nbAccount++) {
            $user = new User();
            if ($nbAccount === 1) {
                $user->setName('dev');
                $user->setEmail('dev@localhost.com');
                $user->setRoles(["ROLE_ADMIN"]);
                $user->setEstablishment($this->getReference('establishment_1'));
                $password = $this->encoder->encodePassword($user, 'password');
            } else {
                $user->setName($faker->name);
                $user->setEmail($faker->email);
                $user->setRoles(["ROLE_CONTRIBUTOR"]);
                $user->setEstablishment($this->getReference('establishment_' . $faker->numberBetween(2, 3)));
                $password = $this->encoder->encodePassword($user, 'user');
            }
            // Add reference for the others fixtures
            $this->addReference('user_' . $nbAccount, $user);

            $user->setPassword($password);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EstablishmentFixtures::class
        ];
    }
}
