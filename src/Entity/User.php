<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;



#[ORM\Entity(repositoryClass: UserRepository::class)]
/**
 * @UniqueEntity(fields="email",  message="L'adresse email '{{ value }}' existe déja !")
 * @UniqueEntity(fields="pseudo",  message="Le pseudo '{{ value }}' existe déjà !")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min="5", max="50",minMessage="Le pseudo doit faire au minimum 5 caractères",maxMessage="Le pseudo ne doit pas faire plus de 50 caractères")
     * @Assert\Regex(
     *     pattern="/^[ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑña-zA-Z0-9_]{0,10}$/",
     *     match=true,
     *     message="Ce pseudo n\est pas valide"
     * )
     */

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private $pseudo;


    /**
     * @Assert\Email(
     *     message = "L\'adresse email '{{ value }}' n\'est pas valide."
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z-0-9_.-]+@[a-zA-Z-]+\.[a-zA-Z-.]+$/",
     * 
     *     match=true,
     *     message=" Votre email n'est pas valide "
     * )
     * @Assert\NotBlank()
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];


    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,}$/",
     *     message="Votre mot de passe doit contenir au moins une lettre miniscule, une majucsule, un chiffre et un caractère espécial"
     * )
     * @Assert\Length(min="5", max="20",minMessage= "Votre mot de passe doit avoir au moins 6 caractères", maxMessage= "Votre mot de passe ne doit avoir au plus de 20 caractères")
     * 
     * @Assert\EqualTo(propertyPath ="password_confirmed", message="Votre mot de passe doit être identique")
     */

    #[ORM\Column(type: 'string')]
    private $password;
    /**
     *@Assert\EqualTo(propertyPath ="password", message="Votre mot de passe doit être identique")
     */

    public $password_confirmed;


    /**
     * 
     * @Assert\File(mimeTypes={ "image/jpeg" , "image/png" },
     * mimeTypesMessage = "Veuillez insérer une image type jpeg ou png")
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $avatar;

    #[ORM\Column(type: 'boolean')]
    private $actived;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private $activeToken;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Trick::class, orphanRemoval: true)]
    private $tricks;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tricks = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getActived(): ?bool
    {
        return $this->actived;
    }

    public function setActived(bool $actived): self
    {
        $this->actived = $actived;

        return $this;
    }

    public function getActiveToken(): ?string
    {
        return $this->activeToken;
    }

    public function setActiveToken(?string $activeToken): self
    {
        $this->activeToken = $activeToken;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trick>
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }
}
