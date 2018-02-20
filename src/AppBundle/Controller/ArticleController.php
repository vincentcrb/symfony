<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article_list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository( Article:: class)
            ->findAll();
        return $this->render('default/article.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="article-view", requirements={"id"="\d+"})
     */
    public function viewAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository(Article:: class)
            ->find($id);
        return $this->render('default/article-view.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
    * @Route("/article/add", name="article_add")
    */
    public function addAction(Request $request)
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class)
            ->add( 'label', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('save', SubmitType::class,
                ['label' => 'Ajouter un projet']) ->getForm();

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
    public function editAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article:: class)
            ->find($id);

        $form = $this->createFormBuilder($article)
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class)
            ->add( 'label', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('save', SubmitType::class,
                ['label' => 'Ajouter un projet']) ->getForm();

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
