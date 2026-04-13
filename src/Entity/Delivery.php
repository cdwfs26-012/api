<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DeliveryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
        // CONDITION :
        // Si Admin ou Chauffeur -> OK
        // Si Client -> OK UNIQUEMENT si le paramètre de requête 'client' est présent
            security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_CHAUFFEUR') or (is_granted('ROLE_CLIENT') and request.query.has('client'))",
            securityMessage: "En tant que client, vous devez spécifier un ID client pour filtrer les résultats."
        ),
        new Get(
        // Un client ne voit l'item que si c'est le sien
            security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_CHAUFFEUR') or (is_granted('ROLE_CLIENT') and object.getClient() == user)"
        ),
        new Patch(
            security: "is_granted('ROLE_ADMIN') or is_granted('ROLE_CHAUFFEUR')"
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['client' => 'exact'])]
class Delivery
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $plannedAt = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?Tour $tour = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'deliveries')]
    private ?Address $address = null;

    /**
     * @var Collection<int, DeliveryItem>
     */
    #[ORM\OneToMany(targetEntity: DeliveryItem::class, mappedBy: 'delivery')]
    private Collection $deliveryItems;

    public function __construct()
    {
        $this->deliveryItems = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getPlannedAt(): ?\DateTimeImmutable
    {
        return $this->plannedAt;
    }

    public function setPlannedAt(?\DateTimeImmutable $plannedAt): static
    {
        $this->plannedAt = $plannedAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): static
    {
        $this->tour = $tour;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

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
            $deliveryItem->setDelivery($this);
        }

        return $this;
    }

    public function removeDeliveryItem(DeliveryItem $deliveryItem): static
    {
        if ($this->deliveryItems->removeElement($deliveryItem)) {
            // set the owning side to null (unless already changed)
            if ($deliveryItem->getDelivery() === $this) {
                $deliveryItem->setDelivery(null);
            }
        }

        return $this;
    }
}
