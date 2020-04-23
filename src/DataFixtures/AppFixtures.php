<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        // nous gerons les utilisateurs
        $users = [];
        $genres = ["male", "female"];
        for($i = 0; $i <= 10; $i++){
            $user = new User();

            $genre = $faker->randomElement($genres);
            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1, 99).'.jpg';
            $picture .= ($genre == "male" ? "men/" : "female/" ).$pictureId;

            $hash = $this->encoder->encodePassword($user, "password");
            $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join('<p></p>', $faker->paragraphs(3)).'</p>')
                ->setHash($hash)
                ->setPicture($picture);
            $manager->persist($user);
            $users[] = $user;
        }
        for($i = 0; $i < 30; $i++){
            $ad = new Ad();
            $title = $faker->sentence();
            $coverImage = "http://placehold.it/1000x350";
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('<p></p>', $faker->paragraphs(5)).'</p>';
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setPrice(mt_rand(40, 400))
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setCoverImage($coverImage)
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);
            $manager->persist($ad);
            //creation entre 2 et 4 images aleatoires
            for($j = 1; $j < mt_rand(2, 4); $j++){
                $image = new Image();
                $image->setUrl("http://placehold.it/640x480")
                // $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }
        }

        $manager->flush();
    }
}
