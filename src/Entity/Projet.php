<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Board::class, mappedBy="projet", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $board;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->board = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Board[]
     */
    public function getBoard(): Collection
    {
        return $this->board;
    }

    public function addBoard(Board $board): self
    {
        if (!$this->board->contains($board)) {
            $this->board[] = $board;
            $board->setProjet($this);
        }

        return $this;
    }

    public function removeBoard(Board $board): self
    {
        if ($this->board->removeElement($board)) {
            // set the owning side to null (unless already changed)
            if ($board->getProjet() === $this) {
                $board->setProjet(null);
            }
        }

        return $this;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
