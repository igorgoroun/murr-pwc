<?php

namespace App\Controller;

use App\Entity\ForumPost;
use App\Entity\ForumTopic;
use App\Form\ForumPostQuickType;
use App\Form\ForumPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ForumPostController extends AbstractController
{

    /**
     * @Route("/forum/post/modify/{id}", name="forum_post_modify", requirements={"id"="\d+"})
     */
    public function modify(ForumPost $post, Request $request) {
        try {
            try {
                if ($this->getUser() != $post->getUser()) {
                    throw new AccessDeniedException("");
                }
            } catch (AccessDeniedException $e) {
                $this->denyAccessUnlessGranted('ROLE_EDITOR');
            }
        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "No access!");
            return $this->redirectToRoute('forum');
        }

        $form = $this->createForm(ForumPostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setModified(new \DateTime());
            $post->setModifiedUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $topic = $post->getTopic();
            $topic->setModified(new \DateTime());
            $em->persist($topic);
            $em->flush();
            return $this->redirectToRoute('forum_topic', ['id' => $post->getTopic()->getId()]);
        }
        return $this->render('forum/form-post-separate.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);

    }

    /**
     * @Route("/forum/post/create/{id}", name="forum_post_create", requirements={"id"="\d+"})
     */
    public function create(ForumTopic $topic, Request $request)
    {
        try {
            $this->denyAccessUnlessGranted($topic->getAccess()->getRole());
        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "No access!");
            return $this->redirectToRoute('forum');
        }
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
            $topic->setModified(new \DateTime());
            $em->persist($topic);
            $em->flush();
            return $this->redirectToRoute('forum_topic', ['id' => $topic->getId()]);
        }
        return $this->render('forum/form-post-separate.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
