<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Form\ForumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    /**
     * @Route("/forum/modify/{id}", name="forum_modify", requirements={"id"="\d+"})
     * @param Forum $forum
     * @param Request $request
     * @return Response
     */
    public function modify(Forum $forum, Request $request) {
        if (!$forum) {
            $this->addFlash("danger", "Invalid forum requested");
            return $this->redirectToRoute('forum');
        }

        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/form-forum.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/create", name="forum_create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request) {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/form-forum.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum", name="forum")
     */
    public function index() {
        $em = $this->getDoctrine();
        $forums = $em->getRepository('App:Forum')->findAll();
        foreach ($forums as &$forum) {
            foreach ($forum->getDirectories() as &$directory) {
                if ($this->isGranted($directory->getAccess()->getRole())) {
                    $ps = $em->getRepository('App:ForumPost')->findBy(['directory' => $directory], ['created' => 'DESC'], 1);
                    if (count($ps)>0) $directory->setLatestPost($ps[0]);
                    $forum->addVisibleDir($directory);
                }
            }
        }

        return $this->render('forum/index.html.twig', [
            'forums' => $forums,
        ]);
    }
}
