<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Email(message: 'Некорректный адрес почты')]
    #[Assert\NotBlank(message: 'Поле обязательно для заполнения')]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $emailVerifiedAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: "user", cascade: ["remove"])]
    private Collection $comments;

    /**
     * @var Collection<int, FavoriteFilm>
     */
    #[ORM\OneToMany(targetEntity: FavoriteFilm::class, mappedBy: 'user')]
    private Collection $favoriteFilms;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $apiToken = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favoriteFilms = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getEmailVerifiedAt(): ?DateTimeImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function setEmailVerifiedAt(?DateTimeImmutable $emailVerifiedAt): static
    {
        $this->emailVerifiedAt = $emailVerifiedAt;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteFilm>
     */
    public function getFavoriteFilms(): Collection
    {
        return $this->favoriteFilms;
    }

    public function addFavoriteFilm(FavoriteFilm $favoriteFilm): static
    {
        if (!$this->favoriteFilms->contains($favoriteFilm)) {
            $this->favoriteFilms->add($favoriteFilm);
            $favoriteFilm->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteFilm(FavoriteFilm $favoriteFilm): static
    {
        if ($this->favoriteFilms->removeElement($favoriteFilm)) {
            // set the owning side to null (unless already changed)
            if ($favoriteFilm->getUser() === $this) {
                $favoriteFilm->setUser(null);
            }
        }

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (!in_array('ROLE_USER', $roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRoleById(int $roleId): self
    {
        $rolesMap = [
            1 => 'ROLE_USER',
            2 => 'ROLE_MODERATOR',
        ];

        $roleName = $rolesMap[$roleId] ?? 'ROLE_USER';
        $this->roles = [$roleName];
        return $this;
    }

    public function eraseCredentials() : void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier() : string
    {
        return (string) $this->id;
    }
}
