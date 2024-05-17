<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 512, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'profile')]
    private Collection $users;

    /**
     * @var Collection<int, Appauthorization>
     */
    #[ORM\OneToMany(targetEntity: Appauthorization::class, mappedBy: 'profile', orphanRemoval: true, cascade: ['persist'])]
    private Collection $appauthorizations;

    #[ORM\Column]
    private ?bool $isSuperadmin = false;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setProfile($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfile() === $this) {
                $user->setProfile(null);
            }
        }

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
            $appauthorization->setProfile($this);
        }

        return $this;
    }

    public function removeAppauthorization(Appauthorization $appauthorization): static
    {
        if ($this->appauthorizations->removeElement($appauthorization)) {
            // set the owning side to null (unless already changed)
            if ($appauthorization->getProfile() === $this) {
                $appauthorization->setProfile(null);
            }
        }

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
