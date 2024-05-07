<?php

namespace App\Entity;

use App\Repository\AppauthorizationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppauthorizationRepository::class)]
class Appauthorization
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $level = null;

    #[ORM\ManyToOne(inversedBy: 'appauthorizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(inversedBy: 'appauthorizations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appsubfunction $appsubfunction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

        return $this;
    }

    public function getAppsubfunction(): ?Appsubfunction
    {
        return $this->appsubfunction;
    }

    public function setAppsubfunction(?Appsubfunction $appsubfunction): static
    {
        $this->appsubfunction = $appsubfunction;

        return $this;
    }
}
