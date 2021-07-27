<?php

namespace App\Entity;

use App\Repository\WidgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WidgetRepository::class)
 */
class Widget
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\ManyToMany(targetEntity=Establishment::class, inversedBy="widgets")
     */
    private $establishment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $domain_allowed;

    public function __construct()
    {
        $this->establishment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection|Establishment[]
     */
    public function getEstablishment(): Collection
    {
        return $this->establishment;
    }

    public function addEstablishment(Establishment $establishment): self
    {
        if (!$this->establishment->contains($establishment)) {
            $this->establishment[] = $establishment;
        }

        return $this;
    }

    public function removeEstablishment(Establishment $establishment): self
    {
        $this->establishment->removeElement($establishment);

        return $this;
    }

    public function getDomainAllowed(): ?string
    {
        return $this->domain_allowed;
    }

    public function setDomainAllowed(?string $domain_allowed): self
    {
        $this->domain_allowed = $domain_allowed;

        return $this;
    }
}
