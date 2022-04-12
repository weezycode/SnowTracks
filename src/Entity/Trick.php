<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TrickRepository::class)]

/**
 *@UniqueEntity(fields="name",  message="Ce nom de trick '{{ value }}' existe déja, Veuillez changer le nom du trick !")
 */

class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\Length(min="5", max="50",minMessage="Le nom doit faire au minimum 5 caractères",maxMessage="Le nom ne doit pas faire plus de 50 caractères")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/[a-zA-Z._\p{L}-]{1,20}/",
     *     message="Not valid name: Veuillez juste mettre des lettres"
     * )
     */

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private $name;

    /**
     * @Assert\Length(min="5",minMessage="Le nom doit faire au minimum 5 caractères")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/[a-zA-Z0-9._\p{L}-]{1,20}/",
     *     message="Vérifier votre contenu"
     * )
     */

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tricks')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;


    #[ORM\OneToMany(mappedBy: "trick", targetEntity: Video::class, cascade: ["persist", "remove"])]


    private $videos;

    #[ORM\OneToMany(mappedBy: "trick", targetEntity: Image::class,  cascade: ["persist", "remove"])]
    private ?Collection $image;

    #[ORM\ManyToOne(targetEntity: Groupe::class, inversedBy: 'trick')]
    #[ORM\JoinColumn(nullable: false)]
    private $groupe;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comment::class, cascade: ["persist", "remove"])]
    private $comments;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $slug;


    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }



    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
