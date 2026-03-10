<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Emprunt;
// use App\Form\BookType;
use App\Repository\BookRepository;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/emprunt')]
final class EmpruntController extends AbstractController
{
    #[Route(name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager, Book $book): Response
    {
        $emprunt = new Emprunt();
        $emprunt-> setBook($book);
        $emprunt->setUser($this->getUser());
        $book = $bookRepository -> find($id);

        $emprunt->setDateEmprunt(new DateTimeImmutable());
        $emprunt->setStatut("en cours");
        $currentStock = $book->getStock() - 1;
        $book->setStock($currentStock);

        $entityManager->persist($emprunt);
        $entityManager->flush();
        // setuser et set book pas forcément nécessaire
        // $emprunt->setDateRetour(new DateTimeImmutable());
        // $emprunt->setStatut("rendu");
        // $emprunt->setUser($id);
        // $emprunt->setBook($id);
        // $currentStock = $book->getStock() + 1;
        // $book->setStock($currentStock);

        // $entityManager->persist($emprunt);

        $this->addFlash('success', "Livre emprunté.");

        return $this->redirectToRoute('app_catalog', [], Response::HTTP_SEE_OTHER);
        
        
    }

        #[Route('/{id}/returnBook', name: 'app_emprunt_return', methods: ['GET', 'POST'])]
    public function returnBook($id, Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager, Book $book): Response
    {
        $emprunt = new Emprunt();
        $emprunt-> setBook($book);
        $emprunt->setUser($this->getUser());
        $book = $bookRepository -> find($id);

        $emprunt->setDateRetour(new DateTimeImmutable());
        $emprunt->setStatut("Restitué");
        $currentStock = $book->getStock() + 1;
        $book->setStock($currentStock);

        $entityManager->persist($emprunt);
        $entityManager->flush();
        // setuser et set book pas forcément nécessaire
        // $emprunt->setDateRetour(new DateTimeImmutable());
        // $emprunt->setStatut("rendu");
        // $emprunt->setUser($id);
        // $emprunt->setBook($id);
        // $currentStock = $book->getStock() + 1;
        // $book->setStock($currentStock);

        $entityManager->persist($emprunt);

        $this->addFlash('success', "Livre emprunté.");


        return $this->redirectToRoute('app_catalog', [], Response::HTTP_SEE_OTHER);

        
    }

    #[Route('/{id}/emprunt/history', name: 'app_emprunt_show', methods: ['GET', 'POST"'])]
    public function show($id, BookRepository $bookRepository, EmpruntRepository $empruntRepo): Response
    {
        $book = $bookRepository -> find($id);
        $empruntHistory = $empruntRepo->findBy(['book'=>$book],['id'=>'DESC']);

        return $this->render('emprunt/show.html.twig', [
            'tousLesEmprunts' => $empruntHistory,
            'book'=> $book
        ]);
    }   
    
    #[Route('/emprunt/all/', name: 'app_emprunt_all', methods: ['GET', 'POST"'])]
    public function showAll(UserRepository $userRepository, EmpruntRepository $empruntRepo, BookRepository $bookRepository): Response
    {
        $allEmprunt = $empruntRepo -> findAll();
        // $empruntHistory = $empruntRepo->findBy(['book'=>$book],['id'=>'DESC']);
        $book = $bookRepository -> findAll();
        $user = $userRepository -> findAll();


        return $this->render('emprunt/showAll.html.twig', [
            'tousLesEmprunts' => $allEmprunt,
            'book' => $book,
            'user' =>$user,
        ]);
    }


}
