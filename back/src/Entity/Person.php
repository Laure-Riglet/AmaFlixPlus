<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $birthdate = null;

    #[ORM\Column(length: 255)]
    private ?string $birthplace = null;

    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: 'people')]
    private Collection $nationality;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: Credit::class, orphanRemoval: true)]
    private Collection $credits;

    public function __construct()
    {
        $this->nationality = new ArrayCollection();
        $this->credits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeImmutable $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getBirthplace(): ?string
    {
        return $this->birthplace;
    }

    public function setBirthplace(string $birthplace): self
    {
        $this->birthplace = $birthplace;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getNationality(): Collection
    {
        return $this->nationality;
    }

    public function addNationality(Country $nationality): self
    {
        if (!$this->nationality->contains($nationality)) {
            $this->nationality->add($nationality);
        }

        return $this;
    }

    public function removeNationality(Country $nationality): self
    {
        $this->nationality->removeElement($nationality);

        return $this;
    }

    /**
     * @return Collection<int, Credit>
     */
    public function getCredits(): Collection
    {
        return $this->credits;
    }

    public function addCredit(Credit $credit): self
    {
        if (!$this->credits->contains($credit)) {
            $this->credits->add($credit);
            $credit->setPerson($this);
        }

        return $this;
    }

    public function removeCredit(Credit $credit): self
    {
        if ($this->credits->removeElement($credit)) {
            // set the owning side to null (unless already changed)
            if ($credit->getPerson() === $this) {
                $credit->setPerson(null);
            }
        }

        return $this;
    }
}
