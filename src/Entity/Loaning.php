<?php

namespace App\Entity;

use App\Repository\LoaningRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoaningRepository::class)]
class Loaning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $loanDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $returnDate = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'loaning')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'loaning')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'loanings')]
    private ?book $book_id = null;

    #[ORM\ManyToOne(inversedBy: 'loanings')]
    private ?user $user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLoanDate(): ?\DateTimeImmutable
    {
        return $this->loanDate;
    }

    public function setLoanDate(\DateTimeImmutable $loanDate): static
    {
        $this->loanDate = $loanDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeImmutable
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeImmutable $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBookId(): ?book
    {
        return $this->book_id;
    }

    public function setBookId(?book $book_id): static
    {
        $this->book_id = $book_id;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }
}
