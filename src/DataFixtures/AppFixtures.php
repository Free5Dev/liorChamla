<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // faker
        $faker = \Faker\Factory::create("fr_FR");
        // creation entre 4 et Categorie fakées
        for($c = 0; $c < mt_rand(4, 6); $c++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph());
            $manager->persist($category);
            // creation de 30 articles fakés
            for($a = 0; $a < 30; $a++){
                $article = new Article();
                $article->setTitle($faker->sentence())
                        ->setContent("<p>".join("<p></p> ",$faker->paragraphs(3))."</p>")
                        ->setImage($faker->imageUrl())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);
                $manager->persist($article);
                // creation entre 6 et 8 commentaires
                for($i = 0; $i < mt_rand(4, 10); $i++){
                    $comment = new Comment();
                    $days=(new \DateTime())->diff($article->getCreatedAt())->days;
                    $comment->setAuthor($faker->name)
                            ->setContent("<p>".join("<p></p> ",$faker->paragraphs(5))."</p>")
                            ->setCreatedAt($faker->dateTimeBetween('-'.$days.' days'))
                            ->setArticle($article);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
