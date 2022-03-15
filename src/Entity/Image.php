<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $idTrick;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTrick(): ?int
    {
        return $this->idTrick;
    }

    public function setIdTrick(int $idTrick): self
    {
        $this->idTrick = $idTrick;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
