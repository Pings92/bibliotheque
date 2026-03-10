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
// chemin qui montre tous les emprunts en cours
    #[Route(name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $empruntRepository->findAll(),
        ]);
    }
// Chemin pour faire un nouvel emprunt à l'appuie du bouton FONCTIONNE
    #[Route('/{id}/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    public function new($id, Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager, Book $book): Response
    {
        $emprunt = new Emprunt();
        $emprunt-> setBook($book);
        $emprunt-> setUser($this->getUser());
        $book = $bookRepository -> find($id);

        $emprunt->setDateEmprunt(new DateTimeImmutable());
        $emprunt->setStatut("en cours");
        $currentStock = $book->getStock() - 1;
        $book->setStock($currentStock);

        $entityManager->persist($emprunt);
        $entityManager->flush();

        $this->addFlash('success', "Livre emprunté.");

        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
    }
// Chemin pour faire un retour d'un livre à l'appuie du bouton restituer
    #[Route('/{id}/returnBook', name: 'app_emprunt_return', methods: ['GET', 'POST'])]
    public function returnBook($id, Request $request, BookRepository $bookRepository, Emprunt $emprunt, EntityManagerInterface $entityManager, Book $book): Response
    {
        $emprunt-> setBook($book);
        $emprunt->setUser($this->getUser());
        $book = $bookRepository -> find($id);

        $emprunt->setDateRetour(new DateTimeImmutable());
        $emprunt->setStatut("Restitué");

        $book = $emprunt->getBook();
        $book->setStock($book->getStock() + 1);
        // $currentStock = $book->getStock() + 1;
        // $book->setStock($currentStock);

        // $entityManager->persist($emprunt);
        $entityManager->flush();

        $this->addFlash('success', "Livre rendu.");

        // retourne sur la liste des emprunts en cours
        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);

        
    }

// Code Gemini
// #[Route('/{id}/return', name: 'app_emprunt_return', methods: ['GET', 'POST'])]
// public function returnBook(
//     Emprunt $emprunt, // Symfony récupère automatiquement l'emprunt via l'ID
//     EntityManagerInterface $entityManager
// ): Response {
//     // 1. On vérifie si le livre n'a pas déjà été rendu pour éviter les doublons de stock


//     // 2. Mise à jour de l'emprunt (pas de "new Emprunt")
//     $emprunt->setDateRetour(new \DateTimeImmutable());
//     $emprunt->setStatut("Restitué");

//     // 3. Mise à jour du stock du livre associé
//     $book = $emprunt->getBook();
//     $book->setStock($book->getStock() + 1);

//     // 4. On enregistre les modifications
//     // Pas besoin de persist($emprunt) car l'objet vient déjà de la BDD
//     $entityManager->flush();

//     $this->addFlash('success', "Le livre a bien été restitué.");

//     return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
// }





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
    // C'est la route qui montre l'historique de tous les emprunts
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
