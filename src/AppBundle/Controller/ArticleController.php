<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Manager\ArticleManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;



class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article_list")
     */
    public function listAction(ArticleManager $articleManager)
    {
        $articles = $articleManager->getArticles();

        return $this->render('default/article.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article-view", requirements={"id"="\d+"})
     */
    public function viewAction(ArticleManager $articleManager, $id)
    {
        $articles = $articleManager->getArticle($id);

        if(!empty($articles)){
            return $this->render('default/article-view.html.twig', [
                'articles' => $articles
            ]);
        }
        else{
            throw new BadRequestHttpException( '404, Project not found.');
        }
    }

    /**
    * @Route("/article/add", name="article_add")
    */
    public function addAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType:: class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
        $article = $form->getData();
        $em = $this->getDoctrine()->getManager(); $em->persist($article);
        $em->flush();
        return $this->redirectToRoute('article_list');
        }

        return $this->render('default/article-add.html.twig', [ 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/edit/{id}", name="article_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article:: class)
            ->find($id);

        $form = $this->createForm(ArticleType:: class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager(); $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('article_list');
        }

        return $this->render('default/article-add.html.twig', [ 'form' => $form->createView()
        ]);
    }
}
