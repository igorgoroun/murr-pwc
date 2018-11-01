<?php

namespace App\Controller;

use App\Entity\ForumDirectory;
use App\Entity\ForumPost;
use App\Entity\ForumTopic;
use App\Form\ForumPostQuickType;
use App\Form\ForumPostType;
use App\Form\ForumTopicType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ForumTopicController extends AbstractController
{

    /**
     * @Route("/forum/topic/{id}", name="forum_topic", requirements={"id"="\d+"})
     */
    public function index(ForumTopic $topic, Request $request, PaginatorInterface $paginator) {

        try {
            if ($topic->getAccess()->getRole() == "ROLE_GUEST") {
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_ANONYMOUSLY');
            } else {
                $this->denyAccessUnlessGranted($topic->getAccess()->getRole());
            }
        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "No access!");
            return $this->redirectToRoute('forum');
        }

        $rep = $this->getDoctrine()->getRepository('App:ForumPost');
        $posts = $rep->findPaginated($topic);
        $pagination = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            10
        );

        $post = new ForumPost();
        $form = $this->createForm(ForumPostQuickType::class, $post, ['action' => $this->generateUrl('forum_post_create', ['id' => $topic->getId()])]);

        return $this->render('forum/view-topic.html.twig', [
            'posts' => $pagination,
            'topic' => $topic,
            'directory' => $topic->getDirectory(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forum/topic/create/{id}", name="forum_topic_create", requirements={"id"="\d+"})
     */
    public function create(ForumDirectory $directory, Request $request)
    {
        try {
            $this->denyAccessUnlessGranted($directory->getAccess()->getRole());
        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "No access!");
            return $this->redirectToRoute('forum');
        }

        if (!$directory) {
            $this->addFlash("danger", "Can't create topic on non-existent directory!");
            return $this->redirectToRoute("forum");
        }

        $topic = new ForumTopic();
        $topic->setDirectory($directory);
        $topic->setUser($this->getUser());
        $topic->setCreated(new \DateTime());
        $topic->setAccess($directory->getAccess());

        $form = $this->createForm(ForumTopicType::class, $topic);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('warning', "Invalid topic data");
                return $this->redirectToRoute('forum_dir', ['id' => $directory->getId()]);
            }
            $post = new ForumPost();
            $post->setTopic($topic);
            $post->setCreated(new \DateTime());
            $post->setUser($topic->getUser());
            $post->setDirectory($topic->getDirectory());
            $post->setBody($topic->getPostBody());
            $post->setPickTop($topic->getPickedTop());
            $post->setSign($topic->getSign());

            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('forum_topic', ['id' => $topic->getId()]);
        }

        return $this->render('forum/form-topic-ui.html.twig', [
            'form' => $form->createView(),
            'directory' => $directory
        ]);
    }
}
