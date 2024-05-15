<?php

namespace App\Entity;

use App\Repository\AppsubfunctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppsubfunctionRepository::class)]
#[UniqueEntity('name')]    
#[UniqueEntity('slug')]    

class Appsubfunction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'appsubfunctions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appfunction $Appfunction = null;

    /**
     * @var Collection<int, Appauthorization>
     */
    #[ORM\OneToMany(targetEntity: Appauthorization::class, mappedBy: 'appsubfunction', orphanRemoval: true)]
    private Collection $appauthorizations;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $isSuperadmin = null;

    public function __construct()
    {
        $this->appauthorizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAppfunction(): ?Appfunction
    {
        return $this->Appfunction;
    }

    public function setAppfunction(?Appfunction $Appfunction): static
    {
        $this->Appfunction = $Appfunction;

        return $this;
    }

    /**
     * @return Collection<int, Appauthorization>
     */
    public function getAppauthorizations(): Collection
    {
        return $this->appauthorizations;
    }

    public function addAppauthorization(Appauthorization $appauthorization): static
    {
        if (!$this->appauthorizations->contains($appauthorization)) {
            $this->appauthorizations->add($appauthorization);
            $appauthorization->setAppsubfunction($this);
        }

        return $this;
    }

    public function removeAppauthorization(Appauthorization $appauthorization): static
    {
        if ($this->appauthorizations->removeElement($appauthorization)) {
            // set the owning side to null (unless already changed)
            if ($appauthorization->getAppsubfunction() === $this) {
                $appauthorization->setAppsubfunction(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isSuperadmin(): ?bool
    {
        return $this->isSuperadmin;
    }

    public function setSuperadmin(bool $isSuperadmin): static
    {
        $this->isSuperadmin = $isSuperadmin;

        return $this;
    }

   
}
