<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $matricule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Numeros", mappedBy="client")
     */
    private $numeros;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Operations", mappedBy="client")
     */
    private $operations;

    public function __construct()
    {
        $this->numeros = new ArrayCollection();
        $this->ticketNonValide = new ArrayCollection();
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

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection|Numeros[]
     */
    public function getNumeros(): Collection
    {
        return $this->numeros;
    }

    public function addNumero(Numeros $numero): self
    {
        if (!$this->numeros->contains($numero)) {
            $this->numeros[] = $numero;
            $numero->setClient($this);
        }

        return $this;
    }

    public function removeNumero(Numeros $numero): self
    {
        if ($this->numeros->contains($numero)) {
            $this->numeros->removeElement($numero);
            // set the owning side to null (unless already changed)
            if ($numero->getClient() === $this) {
                $numero->setClient(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
            $operation->setClient($this);
        }

        return $this;
    }

    public function removeOperation(Operations $operation): self
    {
        if ($this->operations->contains($operation)) {
            $this->operations->removeElement($operation);
            // set the owning side to null (unless already changed)
            if ($operation->getClient() === $this) {
                $operation->setClient(null);
            }
        }

        return $this;
    }   
}
