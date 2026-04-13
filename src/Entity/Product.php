<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(nullable: true)]
    private ?float $volume = null;

    /**
     * @var Collection<int, DeliveryItem>
     */
    #[ORM\OneToMany(targetEntity: DeliveryItem::class, mappedBy: 'product')]
    private Collection $deliveryItems;

    public function __construct()
    {
        $this->deliveryItems = new ArrayCollection();
    }


    public function getId(): ?Uuid
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


    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setVolume(?float $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return Collection<int, DeliveryItem>
     */
    public function getDeliveryItems(): Collection
    {
        return $this->deliveryItems;
    }

    public function addDeliveryItem(DeliveryItem $deliveryItem): static
    {
        if (!$this->deliveryItems->contains($deliveryItem)) {
            $this->deliveryItems->add($deliveryItem);
            $deliveryItem->setProduct($this);
        }

        return $this;
    }

    public function removeDeliveryItem(DeliveryItem $deliveryItem): static
    {
        if ($this->deliveryItems->removeElement($deliveryItem)) {
            // set the owning side to null (unless already changed)
            if ($deliveryItem->getProduct() === $this) {
                $deliveryItem->setProduct(null);
            }
        }

        return $this;
    }
}
