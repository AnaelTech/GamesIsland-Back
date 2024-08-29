<?php

namespace App\Entity;

use App\Repository\WishListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: WishListRepository::class)]
#[ApiResource()]
class WishList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Game>
     */
    #[ORM\OneToMany(targetEntity: Game::class, mappedBy: 'wishList')]
    private Collection $Game;

    #[ORM\ManyToOne(inversedBy: 'wishLists')]
    private ?User $User = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLike = null;

    public function __construct()
    {
        $this->Game = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->Game;
    }

    public function addGame(Game $game): static
    {
        if (!$this->Game->contains($game)) {
            $this->Game->add($game);
            $game->setWishList($this);
        }

        return $this;
    }

    public function removeGame(Game $game): static
    {
        if ($this->Game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getWishList() === $this) {
                $game->setWishList(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

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

    public function isLike(): ?bool
    {
        return $this->isLike;
    }

    public function setLike(?bool $isLike): static
    {
        $this->isLike = $isLike;

        return $this;
    }
}
