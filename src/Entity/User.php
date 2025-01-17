<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\meController;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'dtype', type: 'string')]
#[ORM\DiscriminatorMap(['user' => User::class, 'developer' => Developer::class])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(
            name: 'me',
            uriTemplate: '/me',
            controller: meController::class,
            read: false
        ),
        new Get(),
        new Patch(),
        new Put(),
        new Post(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['user:read', 'user:write']],
    denormalizationContext: ['groups' => ['user:read', 'user:write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['email' => 'exact'])]
#[ApiFilter(SearchFilter::class, properties: ['roles' => 'partial', 'id' => 'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(["user:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[Groups(["user:read", "user:write"])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom d\'utilisateur ne doit pas être vide.')]
    #[Assert\Length(min: 3, minMessage: 'Le nom d\'utilisateur doit faire au moins 3 caractères.')]
    private ?string $username = null;

    #[Groups(["user:read", "user:write"])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'email ne doit pas être vide.')]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide.')]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[Groups(["user:read"])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Groups(["user:read", "user:write"])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le mot de passe est obligatoire.')]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateJoined = null;

    #[Groups(["user:read", "user:write"])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[Groups(["user:read"])]
    #[ORM\Column]
    private ?bool $isActive = null;

    #[Groups(["user:read"])]
    #[ORM\OneToOne(targetEntity: WishList::class, mappedBy: "user", cascade: ["persist", "remove"])]
    private ?WishList $wishList = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resetToken = null;

    public function __construct()
    {
        $this->dateJoined = new \DateTime();
        $this->isActive = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = "ROLE_USER";

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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

    public function getDateJoined(): ?\DateTimeInterface
    {
        return $this->dateJoined;
    }

    public function setDateJoined(\DateTimeInterface $dateJoined): static
    {
        $this->dateJoined = $dateJoined;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function eraseCredentials(): void {}

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getWishList(): ?WishList
    {
        return $this->wishList;
    }

    public function setWishList(?WishList $wishList): static
    {
        if ($wishList !== null && $wishList->getUser() !== $this) {
            $wishList->setUser($this);
        }

        $this->wishList = $wishList;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): static
    {
        $this->resetToken = $resetToken;

        return $this;
    }
}
