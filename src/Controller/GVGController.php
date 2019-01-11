<?php

namespace App\Controller;

use App\Entity\GVG;
use App\Entity\GVGParty;
use App\Entity\GVGPresence;
use App\Form\GVGPartyType;
use App\Form\GVGType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GVGController extends AbstractController
{

    /**
     * @Route("/gvg/party/presence/{party}/{presence}", name="gvg_party_presence", requirements={"party"="\d+","presence"="\d+"})
     */
    public function setPartyToPresence(GVGParty $party, GVGPresence $presence) {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');
        if (!$party or !$presence) {
            $this->addFlash("danger", "Invalid party/presence requested");
            return $this->redirectToRoute('gvg_upcoming');
        }

        $presence->setParty($party);
        $em = $this->getDoctrine()->getManager();
        $em->persist($presence);
        $em->flush();

        return $this->redirectToRoute('gvg_presence', ['id' => $presence->getGvg()->getId()]);
    }

    /**
     * @Route("/gvg/party/modify/{id}", name="gvg_party_modify", requirements={"id"="\d+"})
     */
    public function modifyParty(GVGParty $party, Request $request) {
        if (!$party) {
            $this->addFlash("danger", "Invalid party requested");
            return $this->redirectToRoute('gvg_party_list');
        }

        $form = $this->createForm(GVGPartyType::class, $party);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('gvg_party_list');
        }

        return $this->render("gvg/form-party.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/gvg/party/create", name="gvg_party_create")
     */
    public function createParty(Request $request) {
        $party = new GVGParty();

        $form = $this->createForm(GVGPartyType::class, $party);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($party);
            $em->flush();
            return $this->redirectToRoute('gvg_party_list');
        }

        return $this->render("gvg/form-party.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/gvg/parties", name="gvg_party_list")
     */
    public function listPartyTemplates() {
        $tpls = $this->getDoctrine()->getRepository('App:GVGParty')->findBy([], ['name'=>'ASC']);
        return $this->render('gvg/list-templates.html.twig', [
            'templates' => $tpls
        ]);
    }

    /**
     * @Route("/gvg/presence/{id}", name="gvg_presence", requirements={"id"="\d+"})
     */
    public function listPresence(GVG $gvg, Request $request, PaginatorInterface $paginator) {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        //$presences = $em->getRepository('App:GVGPresence')->findBy(['gvg' => $gvg], ['party' => 'ASC', 'promise' => 'DESC']);
        $presences = $em->getRepository('App:GVGPresence')->findPaginated($gvg);
        //dump($presences->getSQL());
        //exit();
        $pagination = $paginator->paginate(
            $presences,
            $request->query->getInt('page', 1),
            200
        );

        dump($pagination);

        $parties = $em->getRepository('App:GVGParty')->findBy([], ['name'=>'ASC']);
        return $this->render('gvg/list-presence.html.twig', [
            'gvg' => $gvg,
            'presences' => $pagination,
            'parties' => $parties,
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
            return $this->redirectToRoute('gvg_upcoming');
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
