<?php

namespace App\DataFixtures;

use App\Entity\Tip;
use App\Entity\Tag;
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

        $tags = [
            "HTML",
            "CSS",
            "PHP",
            "Symfony",
            "JavaScript",
            "JQuery",
            "Bootstrap",
            "Angular",
            "Vue",
            "NodeJS",
            "Express",
            "SQL",
            "MongoDB",
            "MySQL",
            "PostgreSQL",
            "SQLite",
            "NoSQL",
            "Git",
            "Python",
            "Django",
            "C#",
            "C++",
            "C",
            "Unity",
            "Unity3D",
            "UnityScript",
            "Android",
            "iOS",
            "Swift",
            "Objective-C",
            "Kotlin",
            "Rust",
            "Ruby",
            "Rails",
            "Dart",
            "Elixir",
            "Erlang",
            "Haskell",
            "Scala",
            "Clojure",
            "Elm",
            "Java",
            "Groovy",
            "json",
            "XML",
            "yaml",
            "asp.net",
            "regex",
            "linux",
            "windows",
            "macOS",
            "unix",
            "ajax",
            "API",
            "rest",
            "soap",
            "vba",
            "Typescript",
            "Laravel",
            "ThreeJS",
            "Webgl",
            "Webpack",
            "Wordpress",
            "Joomla",
            "Drupal",
            "Magento",
            "CakePHP",
            "Prestashop",
            "CMS",
            "Bash",
            "GitLab",
            "GitHub",
            "Gitbucket",
            "String",
            "Array",
            "Object",
            "Boolean",
            "Number",
            "Function",
            "Firebase",
            "Flutter",
            "ReactNative",
            "ReactJS",
            "VisualStudio",
            "Eclipse",
            "SublimeText",
            "VSCode",
            "Azure",
            "AWS",
            "GoogleCloud",
            "Heroku",
            "DigitalOcean",
            "Netlify",
            "Docker",
            "Image",
            "Algorithm",
            "Powershell",
            "Apache",
            "Nginx",
            "AndroidStudio",
            "CSV",
            "Markdown",
            "Date",
            ".htaccess",
            "XCode"
        ];
        foreach ($tags as $key => $value){ 
            $tag = new Tag(); 
            $tag->setName($value); 
            $manager->persist($tag); 
        }

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
            
            /*for ($t=0; $t < 2; $t++) { 
                $tip = new Tip();
                $tip->setTitle($faker->realText(30))
                    ->setContent($html)
                    ->setUser($user)
                ;
                $manager->persist($tip);
            }*/

            $manager->persist($user);
        }


        $manager->flush();
    }
}
