<?php

namespace HyperBookBundle\Controller;

use HyperBookBundle\Entity\Book;
use HyperBookBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/category", name="category")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/", name="cat_home")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('HyperBookBundle:Category')->findAll();

        return $this->render('HyperBookBundle:Category:index.html.twig', ["categories" => $category]);
    }

    /**
     * @Route("/add", name="cat_add")
     */
    public function addAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $category = new Category();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createFormBuilder($category)
            ->add('title', 'text', ['attr' => ['class' => 'toto']])
            ->add('author', 'text', ['attr' => ['class' => 'toto']])
            ->add('description', 'text', ['attr' => ['class' => 'toto']])
            ->add('imageFile', 'file', ['attr' => ['class' => 'toto']])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = new Book();
            $book->setTitle();
            $book->setAuthor();
            $book->setCategory();
            $book->setDescription();
            $book->setTotalDl(0);
            $book->setImageName();

            $em->persit($book);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}