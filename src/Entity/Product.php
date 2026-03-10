<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $platform = null;

    #[ORM\Column(nullable: true)]
    private ?int $releaseYear = null;

    #[ORM\Column]
    private int $stock = 0;

    #[ORM\Column]
    private bool $active = true;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    /**
     * @var Collection<int, CartItem>
     */
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'produit')]
    private Collection $panierItems;

    public function __construct()
    {
        $this->panierItems = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getPrice(): ?string { return $this->price; }
    public function setPrice(string $price): static { $this->price = $price; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): static { $this->image = $image; return $this; }

    public function getPlatform(): ?string { return $this->platform; }
    public function setPlatform(?string $platform): static { $this->platform = $platform; return $this; }

    public function getReleaseYear(): ?int { return $this->releaseYear; }
    public function setReleaseYear(?int $releaseYear): static { $this->releaseYear = $releaseYear; return $this; }

    public function getStock(): int { return $this->stock; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }

    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): static { $this->active = $active; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $category): static { $this->category = $category; return $this; }

    public function __toString(): string { return $this->name ?? ''; }

    /**
     * @return Collection<int, CartItem>
     */
    public function getPanierItems(): Collection
    {
        return $this->panierItems;
    }

    public function addPanierItem(CartItem $panierItem): static
    {
        if (!$this->panierItems->contains($panierItem)) {
            $this->panierItems->add($panierItem);
            $panierItem->setProduct($this);
        }

        return $this;
    }

    public function removePanierItem(CartItem $panierItem): static
    {
        if ($this->panierItems->removeElement($panierItem)) {
            // set the owning side to null (unless already changed)
            if ($panierItem->getProduct() === $this) {
                $panierItem->setProduct(null);
            }
        }

        return $this;
    }
}