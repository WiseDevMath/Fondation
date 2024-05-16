<?php

namespace App\Entity;

use App\Repository\AppfunctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppfunctionRepository::class)]
class Appfunction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name = '';

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UpdatedAt = null;

    /**
     * @var Collection<int, Appsubfunction>
     */
    #[ORM\OneToMany(targetEntity: Appsubfunction::class, mappedBy: 'Appfunction', orphanRemoval: true, cascade: ['persist'])]
    private Collection $appsubfunctions;

    public function __construct()
    {
        $this->appsubfunctions = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

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
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Appsubfunction>
     */
    public function getAppsubfunctions(): Collection
    {
        return $this->appsubfunctions;
    }

    public function addAppsubfunction(Appsubfunction $appsubfunction): static
    {
        if (!$this->appsubfunctions->contains($appsubfunction)) {
            $this->appsubfunctions->add($appsubfunction);
            $appsubfunction->setAppfunction($this);
        }

        return $this;
    }

    public function removeAppsubfunction(Appsubfunction $appsubfunction): static
    {
        if ($this->appsubfunctions->removeElement($appsubfunction)) {
            // set the owning side to null (unless already changed)
            if ($appsubfunction->getAppfunction() === $this) {
                $appsubfunction->setAppfunction(null);
            }
        }

        return $this;
    }
}
