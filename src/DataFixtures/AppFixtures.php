<?php

namespace App\DataFixtures;

use App\Entity\Tip;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $html = '
            <h1>Bonjour</h1>
            <p>Test astuce</p>
        ';

        for ($i=0; $i < 6; $i++) {
            $user = new User();
            $pseudo = $faker->firstName();
            $number = random_int(1, 100);
            $user   ->setPseudo($pseudo)
                    ->setEmail("$pseudo.$number@fyc.fr")
                    ->setPassword(
                        $this->userPasswordHasher->hashPassword(
                            $user,
                            "$pseudo-123FYC"
                        )
                    )
            ;
            
            for ($t=0; $t < 2; $t++) { 
                $tip = new Tip();
                $tip->setTitle($faker->realText(30))
                    ->setContent($html)
                    ->setUser($user)
                ;
                $manager->persist($tip);
            }

            $manager->persist($user);
        }


        $manager->flush();
    }
}
