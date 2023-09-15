<?php

namespace App\Entity;

use App\Repository\TestResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestResultRepository::class)]
class TestResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $wrongs_count = null;

    #[ORM\Column]
    private ?int $rights_count = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWrongsCount(): ?int
    {
        return $this->wrongs_count;
    }

    public function setWrongsCount(int $wrongs_count): static
    {
        $this->wrongs_count = $wrongs_count;

        return $this;
    }

    public function getRightsCount(): ?int
    {
        return $this->rights_count;
    }

    public function setRightsCount(int $rights_count): static
    {
        $this->rights_count = $rights_count;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
