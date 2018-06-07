<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PbController extends Controller
{
    /**
     * @Route("/pb", name="pb")
     */
    public function index()
    {
        return $this->render('pb/index.html.twig', [
            'controller_name' => 'PbController',
        ]);
    }
}
