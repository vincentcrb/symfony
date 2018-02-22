<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleManager {

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getArticles()
    {
        return $this->em->getRepository( Article:: class)
            ->findAll();
    }

    public function getArticle($id)
    {
        return $this->em->getRepository( Article:: class)
            ->find($id);
    }

    public function createArticle()
    {

    }
}