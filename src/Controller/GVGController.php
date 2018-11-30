<?php

namespace App\Controller;

use App\Entity\GVG;
use App\Entity\GVGPresence;
use App\Form\GVGType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GVGController extends AbstractController
{
    /**
     * @Route("/gvg/presence/{id}", name="gvg_presence", requirements={"id"="\d+"})
     */
    public function listPresence(GVG $gvg) {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $presences = $gvg->getPresences();
        return $this->render('gvg/list-presence.html.twig', [
            'gvg' => $gvg,
            'presences' => $presences
        ]);
    }

    /**
     * @Route("/gvg/confirm/{id}", name="gvg_confirm", requirements={"id"="\d+"})
     */
    public function gvgConfirm(GVG $gvg) {
        return $this->proceedPresence($gvg, true);
    }

    /**
     * @Route("/gvg/decline/{id}", name="gvg_decline", requirements={"id"="\d+"})
     */
    public function gvgDecline(GVG $gvg) {
        return $this->proceedPresence($gvg, false);
    }

    private function proceedPresence(GVG $gvg, bool $accepted=false) {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $em = $this->getDoctrine()->getManager();
        $presence = new GVGPresence();
        $presence->setUser($this->getUser());
        $presence->setGvg($gvg);
        $presence->setPromise($accepted);
        $em->persist($presence);
        $em->flush();

        $this->addFlash("success", "Принято");
        return $this->redirectToRoute('gvg_upcoming');
    }

    /**
     * @Route("/gvg/modify/{id}", name="gvg_modify", requirements={"id"="\d+"})
     */
    public function modify(GVG $gvg, Request $request) {
        if (!$gvg) {
            $this->addFlash("danger", "Invalid GVG requested");
            return $this->redirectToRoute('forum');
        }

        $form = $this->createForm(GVGType::class, $gvg);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gvg);
            $em->flush();
            return $this->redirectToRoute('gvg_upcoming');
        }

        return $this->render('gvg/form-gvg.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/gvg/create", name="gvg_create")
     */
    public function create(Request $request) {
        $gvg = new GVG();

        $form = $this->createForm(GVGType::class, $gvg);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gvg);
            $em->flush();
            return $this->redirectToRoute('gvg_upcoming');
        }

        return $this->render("gvg/form-gvg.html.twig", [
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/gvg", name="gvg_upcoming")
     */
    public function index() {

        $upcoming = $this->getDoctrine()->getRepository('App:GVG')->findUpcoming();
        $voted = [];
        /** @var GVG $gvg */
        foreach ($upcoming as $gvg) {
            foreach ($gvg->getPresences() as $presence) {
                if ($presence->getUser() == $this->getUser()) {
                    $voted []= $gvg->getId();
                }
            }
        }

        return $this->render('gvg/list.html.twig', [
            'upcoming' => $upcoming,
            'voted' => $voted
        ]);
    }

}
