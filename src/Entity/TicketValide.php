<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketValideRepository")
 */
class TicketValide
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
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Operations", mappedBy="ticketValide", cascade={"persist", "remove"})
     */
    private $operations;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
    
    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getOperations(): ?Operations
    {
        return $this->operations;
    }

    public function setOperations(Operations $operations): self
    {
        $this->operations = $operations;

        // set the owning side of the relation if necessary
        if ($this !== $operations->getTicketValide()) {
            $operations->setTicketValide($this);
        }

        return $this;
    }

}
