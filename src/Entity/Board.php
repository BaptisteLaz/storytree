<?php

namespace App\Entity;

use App\Repository\BoardRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoardRepository::class)
 */
class Board
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
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="board")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $projet;

    /**
     * @ORM\OneToMany(targetEntity=Node::class, mappedBy="board", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $node;



    public function __construct()
    {
        $this->node = new ArrayCollection();
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


    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    /**
     * @return Collection|Node[]
     */
    public function getNode(): Collection
    {
        return $this->node;
    }

    public function addNode(Node $node): self
    {
        if (!$this->node->contains($node)) {
            $this->node[] = $node;
            $node->setBoard($this);
        }

        return $this;
    }

    public function removeNode(Node $node): self
    {
        if ($this->node->removeElement($node)) {
            // set the owning side to null (unless already changed)
            if ($node->getBoard() === $this) {
                $node->setBoard(null);
            }
        }

        return $this;
    }






}
