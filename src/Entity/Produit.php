<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories0", inversedBy="produits",cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueProduit", mappedBy="produit")
     */
    private $historique_produit;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operations", mappedBy="produit")
     */
    private $operations;

    public function __construct()
    {
        $this->historique_produit = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategories0(): ?Categories0
    {
        return $this->categories0;
    }

    public function setCategories0(?Categories0 $categories0): self
    {
        $this->categories0 = $categories0;

        return $this;
    }

    /**
     * @return Collection|HistoriqueProduit[]
     */
    public function getHistoriqueProduit(): Collection
    {
        return $this->historique_produit;
    }

    public function addHistoriqueProduit(HistoriqueProduit $historiqueProduit): self
    {
        if (!$this->historique_produit->contains($historiqueProduit)) {
            $this->historique_produit[] = $historiqueProduit;
            $historiqueProduit->setProduit($this);
        }

        return $this;
    }

    public function removeHistoriqueProduit(HistoriqueProduit $historiqueProduit): self
    {
        if ($this->historique_produit->contains($historiqueProduit)) {
            $this->historique_produit->removeElement($historiqueProduit);
            // set the owning side to null (unless already changed)
            if ($historiqueProduit->getProduit() === $this) {
                $historiqueProduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Operations[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operations $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setProduit($this);
        }

        return $this;
    }

    public function removeOperation(Operations $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getProduit() === $this) {
                $operation->setProduit(null);
            }
        }

        return $this;
    }

}
