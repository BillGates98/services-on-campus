<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
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
    private $nom_service;

    /**
     * @ORM\Column(type="integer")
     */
    private $validite;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Admin", mappedBy="service", cascade={"persist", "remove"})
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Categories0", mappedBy="service", cascade={"persist", "remove"})
     */
    private $categories0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HistoriqueService", mappedBy="service")
     */
    private $historique_service;

    public function __construct()
    {
        $this->categories0 = new ArrayCollection();
        $this->historique_service = new ArrayCollection();
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

    public function getNomService(): ?string
    {
        return $this->nom_service;
    }

    public function setNomService(string $nom_service): self
    {
        $this->nom_service = $nom_service;

        return $this;
    }

    public function getValidite(): ?int
    {
        return $this->validite;
    }

    public function setValidite(int $validite): self
    {
        $this->validite = $validite;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        $this->admin = $admin;

        // set the owning side of the relation if necessary
        if ($this !== $admin->getService()) {
            $admin->setService($this);
        }

        return $this;
    }

    /**
     * @return Collection|Categories0[]
     */
    public function getCategories0(): Collection
    {
        return $this->categories0;
    }

    public function addCategories0(Categories0 $categories0): self
    {
        if (!$this->categories0->contains($categories0)) {
            $this->categories0[] = $categories0;
            $categories0->setService($this);
        }

        return $this;
    }

    public function removeCategories0(Categories0 $categories0): self
    {
        if ($this->categories0->contains($categories0)) {
            $this->categories0->removeElement($categories0);
            // set the owning side to null (unless already changed)
            if ($categories0->getService() === $this) {
                $categories0->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoriqueService[]
     */
    public function getHistoriqueService(): Collection
    {
        return $this->historique_service;
    }

    public function addHistoriqueService(HistoriqueService $historiqueService): self
    {
        if (!$this->historique_service->contains($historiqueService)) {
            $this->historique_service[] = $historiqueService;
            $historiqueService->setService($this);
        }

        return $this;
    }

    public function removeHistoriqueService(HistoriqueService $historiqueService): self
    {
        if ($this->historique_service->contains($historiqueService)) {
            $this->historique_service->removeElement($historiqueService);
            // set the owning side to null (unless already changed)
            if ($historiqueService->getService() === $this) {
                $historiqueService->setService(null);
            }
        }

        return $this;
    }
}
