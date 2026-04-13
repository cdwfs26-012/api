<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\TourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TourRepository::class)]
#[ApiResource(
    // 1. On enlève la sécurité globale qui faisait planter la collection
    operations: [
        new GetCollection(), // La liste reste accessible (filtrée par le SearchFilter)
        new Post(),
        new Get(
        // 2. On met la sécurité spécifiquement sur l'ITEM
            security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_CHAUFFEUR') and object.getDriver() == user)"
        ),
        new Put(security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_CHAUFFEUR') and object.getDriver() == user)"),
        new Patch(security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_CHAUFFEUR') and object.getDriver() == user)"),
        new Delete(security: "is_granted('ROLE_ADMIN')")
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['driver' => 'exact'])]
class Tour
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    /**
     * Le chauffeur est un Utilisateur avec le ROLE_CHAUFFEUR
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'tours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $driver = null;

    /**
     * Liste des livraisons rattachées à cette tournée
     * @var Collection<int, Delivery>
     */
    #[ORM\OneToMany(targetEntity: Delivery::class, mappedBy: 'tour', orphanRemoval: true)]
    private Collection $deliveries;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Récupère l'utilisateur (chauffeur) lié à la tournée
     */
    public function getDriver(): ?User
    {
        return $this->driver;
    }

    /**
     * Assigne un utilisateur (chauffeur) à la tournée
     */
    public function setDriver(?User $driver): static
    {
        $this->driver = $driver;
        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->setTour($this);
        }
        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            if ($delivery->getTour() === $this) {
                $delivery->setTour(null);
            }
        }
        return $this;
    }
}
