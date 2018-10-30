<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CVController extends AbstractController
{
    /**
     * @Route("/cv", name="cv")
     */
    public function index()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        return $this->render('cv/index.html.twig', [
            'controller_name' => 'CVController',
        ]);
    }
}
