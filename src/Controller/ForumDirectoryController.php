<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Entity\ForumDirectory;
use App\Form\ForumDirectoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ForumDirectoryController extends AbstractController
{
    /**
     * @Route("/forum/dir/modify/{id}", name="forum_dir_modify", requirements={"id"="\d+"})
     * @param ForumDirectory $forum
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function modify(ForumDirectory $forum, Request $request) {
        if (!$forum) {
            $this->addFlash("danger", "Invalid forum requested");
            return $this->redirectToRoute('forum');
        }

        $form = $this->createForm(ForumDirectoryType::class, $forum);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forum);
            $em->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/form-dir.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/dir/create/{id}", name="forum_dir_create", requirements={"id"="\d+"})
     * @param Forum $forum
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function create(Forum $forum, Request $request) {
        if (!$forum) {
            return $this->redirectToRoute('forum');
        }
        $dir = new ForumDirectory();
        $dir->setForum($forum);
        $dir->setAccess($forum->getAccess());
        $form = $this->createForm(ForumDirectoryType::class, $dir);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dir);
            $em->flush();
            return $this->redirectToRoute('forum');
        }

        return $this->render('forum/form-dir.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/dir/{id}", name="forum_dir", requirements={"id"="\d+"})
     */
    public function index(ForumDirectory $directory) {
        try {
            if ($directory->getAccess()->getRole() == "ROLE_GUEST") {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');
            } else {
                $this->denyAccessUnlessGranted($directory->getAccess()->getRole());
            }

        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "Access denied");
            return $this->redirectToRoute('forum');
        }
        $em = $this->getDoctrine()->getRepository('App:ForumPost');
        foreach ($directory->getTopics() as &$topic) {
            $ps = $em->findBy(['topic' => $topic], ['created' => 'DESC'], 1);
            if (count($ps)>0) $topic->setLatestPost($ps[0]);
        }
        return $this->render('forum/view-dir.html.twig', [
            'directory' => $directory,
            'topics' => $directory->getTopics(),
        ]);
    }
}
