<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\CartItem;

#[ORM\Entity]
#[ORM\Table(name: "cart")]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: "cart", targetEntity: CartItem::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $items;

    #[ORM\Column(type: "boolean")]
    private bool $checkedOut = false;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    // ── Getters / Setters ── //

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|CartItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CartItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setCart($this);
        }

        return $this;
    }

    public function removeItem(CartItem $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getCart() === $this) {
                $item->setCart(null);
            }
        }

        return $this;
    }

    public function getItemById(int $id): ?CartItem
    {
        foreach ($this->items as $item) {
            if ($item->getId() === $id) {
                return $item;
            }
        }
        return null;
    }

    public function isCheckedOut(): bool
    {
        return $this->checkedOut;
    }

    public function setCheckedOut(bool $checkedOut): self
    {
        $this->checkedOut = $checkedOut;
        return $this;
    }
    public function getItemCount(): int
{
    return count($this->items); // $items = Collection de CartItem
}
}