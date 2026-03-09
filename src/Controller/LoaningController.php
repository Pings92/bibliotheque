<?php

namespace App\Controller;

use Doctrine\ORM\Query\Expr\Func;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
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

    #[Route('/loan', name: 'app_loan_a book')]
    public function new (Request $request){}
        
}
