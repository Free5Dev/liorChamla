<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        for($i = 0; $i < 30; $i++){
            $ad = new Ad();
            $title = $faker->sentence();
            $coverImage = "http://placehold.it/1000x350";
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('<p></p>', $faker->paragraphs(5)).'</p>';
            $ad->setTitle($title)
                ->setPrice(mt_rand(40, 400))
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setCoverImage($coverImage)
                ->setRooms(mt_rand(1, 5));
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
