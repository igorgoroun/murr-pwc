<?php

namespace App\Controller;

use App\Entity\ForumPost;
use App\Entity\ForumTopic;
use App\Form\ForumPostQuickType;
use App\Form\ForumPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForumPostController extends AbstractController
{
    /**
     * @Route("/forum/post/create/{id}", name="forum_post_create", requirements={"id"="\d+"})
     */
    public function create(ForumTopic $topic, Request $request)
    {
        $post = new ForumPost();
        $post->setTopic($topic);
        $post->setUser($this->getUser());
        $post->setDirectory($topic->getDirectory());
        $post->setCreated(new \DateTime());
        $form = $this->createForm(ForumPostType::class, $post);
        $form_quick = $this->createForm(ForumPostQuickType::class, $post);
        $form->handleRequest($request);
        $form_quick->handleRequest($request);
        if (($form->isSubmitted() && $form->isValid()) || ($form_quick->isSubmitted() && $form_quick->isValid())) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('forum_topic', ['id' => $topic->getId()]);
        }
        return $this->render('forum/form-post-separate.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
