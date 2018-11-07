<?php

namespace App\Controller;

use App\Entity\CV;
use App\Entity\CVvote;
use App\Entity\User;
use App\Form\CVType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CVController extends AbstractController
{
    /**
     * @Route("/cv/finalaccept/{id}", name="cv_final_accept", requirements={"id"="\d+"})
     */
    public function cvFinalAccept(CV $cv) {
        return $this->closeVote($cv, true);
    }

    /**
     * @Route("/cv/finaldecline/{id}", name="cv_final_decline", requirements={"id"="\d+"})
     */
    public function cvFinalDecline(CV $cv) {
        return $this->closeVote($cv, false);
    }

    private function closeVote(CV $cv, $accepted) {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $cv->setAccepted($accepted);
        $cv->setClosed(true);
        $em->persist($cv);
        $em->flush();
        $this->addFlash('success', "Заявка закрыта");
        return $this->redirectToRoute('cv_list');
    }

    /**
     * @Route("/cv/accept/{id}", name="cv_accept", requirements={"id"="\d+"})
     */
    public function cvAccept(CV $cv) {
        return $this->proccessVote($cv, true);
    }

    /**
     * @Route("/cv/decline/{id}", name="cv_decline", requirements={"id"="\d+"})
     */
    public function cvDecline(CV $cv) {
        return $this->proccessVote($cv, false);
    }

    private function proccessVote(CV $cv, bool $accepted=false) {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $vote = new CVvote();
        $vote->setAccepted($accepted);
        $vote->setUser($this->getUser());
        $vote->setCv($cv);
        $vote->setCreated(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($vote);
        $em->flush();
        $this->addFlash("success", "Ваше мнение принято");
        return $this->redirectToRoute('cv_view', ['id' => $cv->getId()]);
    }

        /**
     * @Route("/cv/{id}", name="cv_view", requirements={"id"="\d+"})
     */
    public function cvView(CV $cv) {
        if (!$cv) {
            $this->addFlash('danger', "Error");
            return $this->redirectToRoute("cv_list");
        }

        // check user already voted this CV
        $vote_rep = $this->getDoctrine()->getRepository('App:CVvote');
        $user_vote = $vote_rep->findOneBy(['user' => $this->getUser()]);

        // count votes
        $positive = $vote_rep->count(['accepted' => true, 'cv' => $cv]);
        $negative = $vote_rep->count(['accepted' => false, 'cv' => $cv]);

        return $this->render('cv/view.html.twig', [
            'cv' => $cv,
            'voted' => $user_vote?true:false,
            'positive' => $positive,
            'negative' => $negative,
        ]);
    }


    /**
     * @Route("/cv", name="cv_list")
     */
    public function cvList(Request $request, PaginatorInterface $paginator) {
        $rep = $this->getDoctrine()->getRepository('App:CV');

        $cvs = $rep->findPaginated();
        $pagination = $paginator->paginate(
            $cvs,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('cv/list.html.twig', [
            'cvs' => $pagination
        ]);
    }


    /**
     * @Route("/cv/apply", name="cv_apply")
     */
    public function cvApply(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('cv_list');
        }
        $this->denyAccessUnlessGranted('ROLE_GUEST');

        /** @var User $user */
        $user = $this->getUser();
        foreach ($user->getCVs() as $cv) {
            if ($user->getUserRole()->getRole() == 'ROLE_GUEST' && ($cv->isProcessing() || $cv->isAccepted())) {
                //$this->addFlash('danger', 'You are already have processing application');
                return $this->redirectToRoute('cv_list');
            }
        }

        $cv = new CV();
        $cv->setUser($this->getUser());
        $cv->setCreated(new \DateTime());

        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();
            $this->addFlash('success', 'Application send for approvement');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('cv/application.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
