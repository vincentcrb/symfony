<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $article = new Article();
            $article->setName('Article')
            ->setDescription('Premier article')
            ->setPrice(10)
            ->setLabel('Article');

            $manager->persist($article);
            $manager->flush();
    }
}