<?php

namespace App\Entity;

use App\Repository\SuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Etablissement;


#[ORM\Entity(repositoryClass: SuiteRepository::class)]
class Suite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 150)]
    private ?string $image_A = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 15)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $debut_reservation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fin_reservation = null;

    #[ORM\ManyToOne(inversedBy: 'suites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etablissement $etablissement = null;

    #[ORM\OneToMany(mappedBy: 'suite', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImageA(): ?string
    {
        return $this->image_A;
    }

    public function setImageA(string $image_A): self
    {
        $this->image_A = $image_A;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDebutReservation(): ?\DateTimeInterface
    {
        return $this->debut_reservation;
    }

    public function setDebutReservation(?\DateTimeInterface $debut_reservation): self
    {
        $this->debut_reservation = $debut_reservation;

        return $this;
    }

    public function getFinReservation(): ?\DateTimeInterface
    {
        return $this->fin_reservation;
    }

    public function setFinReservation(?\DateTimeInterface $fin_reservation): self
    {
        $this->fin_reservation = $fin_reservation;

        return $this;
    }

    public function getEtablissement(): ?etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?etablissement $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setSuite($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getSuite() === $this) {
                $reservation->setSuite(null);
            }
        }

        return $this;
    }
    public function getPrixTotal(): float
    {
        $prix = $this->getPrix();

        $debutReservation = $this->getDebutReservation();
        $finReservation = $this->getFinReservation();
        if (!$debutReservation || !$finReservation) {
            return 0.0;
        }

        $duree = $finReservation->diff($debutReservation)->days;
        return round($prix * $duree, 2);
    }







    public function __toString()
    {
        return $this->titre;
    }
}
