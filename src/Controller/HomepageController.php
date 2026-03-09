<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(BookRepository $bookRepositery): Response
    {
        $books = $bookRepositery->findAll(); 
        return $this->render('homepage/index.html.twig', [
            'books' => $books,
        ]);
    }
}
