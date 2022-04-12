<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    //use Slug;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png" }
     * mimeTypesMessage = "Veuillez insérer une image type jpeg ou png avec une taille maximun de 4M")
     */
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $filename;

    #[ORM\Column(type: 'boolean')]
    private $main;

    #[ORM\ManyToOne(targetEntity: Trick::class, inversedBy: 'image')]
    #[ORM\JoinColumn(nullable: false)]
    private $trick;



    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getMain(): ?bool
    {
        return $this->main;
    }

    public function setMain(bool $main): self
    {
        $this->main = $main;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
