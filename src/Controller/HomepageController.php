<?php

namespace App\Controller;

use App\Entity\HomepageBlock;
use App\Form\HomepageBlockType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        /* main blocks */
        $rep = $this->getDoctrine()->getRepository('App:HomepageBlock');
        $block_about = $rep->findOneBy(['type' => 'about']);
        $block_cv = $rep->findOneBy(['type' => 'cv']);

        /* forum latest */
        $f_rep = $this->getDoctrine()->getRepository('App:ForumPost');
        $forum_posts = $f_rep->findBy([], ['modified' => 'DESC'], 5);

        /* active CVs */
        $cv_rep = $this->getDoctrine()->getRepository('App:CV');
        $cvs_active = $cv_rep->findBy(['closed' => false], ['created' => 'DESC'], 2);

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'about' => $block_about,
            'cv' => $block_cv,
            'forum' => $forum_posts,
            'cvs' => $cvs_active
        ]);
    }

    /**
     * @Route("/homepage/modify/{id}", name="homepage_modify_block", requirements={"id"="\d+"})
     */
    public function modifyBlock(HomepageBlock $block, Request $request) {
        try {
            $this->denyAccessUnlessGranted('ROLE_EDITOR');
        } catch (AccessDeniedException $e) {
            $this->addFlash("warning", "No access!");
            return $this->redirectToRoute('homepage');
        }

        $homepageBlock = $this->getDoctrine()->getRepository('App:HomepageBlock')->findOneBy([
            'id' => $block->getId()
        ]);
        if (!$homepageBlock) {
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(HomepageBlockType::class, $block);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($homepageBlock);
            $em->flush();
            $this->addFlash("success", "Block was saved.");
            return $this->redirectToRoute('homepage');
        }

        return $this->render("homepage/form.html.twig", [
            'form' => $form->createView()
        ]);
    }

}
