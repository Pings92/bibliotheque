<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(length: 13, unique:true)]
    private ?string $isbn = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * @var Collection<int, loaning>
     */
    #[ORM\OneToMany(targetEntity: loaning::class, mappedBy: 'book')]
    private Collection $loaning;

    /**
     * @var Collection<int, Loaning>
     */
    #[ORM\OneToMany(targetEntity: Loaning::class, mappedBy: 'book_id')]
    private Collection $loanings;

    public function __construct()
    {
        $this->loaning = new ArrayCollection();
        $this->loanings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): static
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, loaning>
     */
    public function getLoaning(): Collection
    {
        return $this->loaning;
    }

    public function addLoaning(loaning $loaning): static
    {
        if (!$this->loaning->contains($loaning)) {
            $this->loaning->add($loaning);
            $loaning->setBook($this);
        }

        return $this;
    }

    public function removeLoaning(loaning $loaning): static
    {
        if ($this->loaning->removeElement($loaning)) {
            // set the owning side to null (unless already changed)
            if ($loaning->getBook() === $this) {
                $loaning->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Loaning>
     */
    public function getLoanings(): Collection
    {
        return $this->loanings;
    }
}
