<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoaningController extends AbstractController
{
    #[Route('/loaning', name: 'app_loaning')]
    public function index(): Response
    {
        return $this->render('loaning/index.html.twig', [
            'controller_name' => 'LoaningController',
        ]);
    }
}
