<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/page/{id}", name="page_view", requirements={"id"="\d+"})
     */
    public function view(Page $page) {
        return $this->render('page/view.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/page/create", name="page_create")
     */
    public function create(Request $request) {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }

        return $this->render('page/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/page/modify/{id}", name="page_modify", requirements={"id"="\d+"})
     */
    public function modify(Page $page, Request $request) {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }

        return $this->render('page/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/page/list", name="page_list")
     */
    public function listPages() {
        $rep = $this->getDoctrine()->getRepository('App:Page');
        $pages = $rep->findBy([], ['name'=>'ASC']);

        return $this->render('page/list.html.twig', [
            'pages' => $pages
        ]);
    }

    public function listMenu() {
        $rep = $this->getDoctrine()->getRepository('App:Page');
        $pages = $rep->findBy(['active'=>true], ['name'=>'ASC']);
        return $this->render('page/part-menu.html.twig', [
            'menu' => $pages
        ]);

    }
}
