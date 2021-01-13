<?php

namespace App\Entity;

use App\Repository\RaceGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaceGroupRepository::class)
 */
class RaceGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\OneToMany(targetEntity=Race::class, mappedBy="raceGroup")
     */
    private $race;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\OneToMany(targetEntity=RaceGroupImages::class, mappedBy="raceGroup")
     */
    private $raceGroupImages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    public function __construct()
    {
        $this->race = new ArrayCollection();
        $this->raceGroupImages = new ArrayCollection();
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

    /**
     * @return Collection|Race[]
     */
    public function getRace(): Collection
    {
        return $this->race;
    }

    public function addRace(Race $race): self
    {
        if (!$this->race->contains($race)) {
            $this->race[] = $race;
            $race->setRaceGroup($this);
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        if ($this->race->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getRaceGroup() === $this) {
                $race->setRaceGroup(null);
            }
        }

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|RaceGroupImages[]
     */
    public function getRaceGroupImages(): Collection
    {
        return $this->raceGroupImages;
    }

    public function addRaceGroupImage(RaceGroupImages $raceGroupImage): self
    {
        if (!$this->raceGroupImages->contains($raceGroupImage)) {
            $this->raceGroupImages[] = $raceGroupImage;
            $raceGroupImage->setRaceGroup($this);
        }

        return $this;
    }

    public function removeRaceGroupImage(RaceGroupImages $raceGroupImage): self
    {
        if ($this->raceGroupImages->removeElement($raceGroupImage)) {
            // set the owning side to null (unless already changed)
            if ($raceGroupImage->getRaceGroup() === $this) {
                $raceGroupImage->setRaceGroup(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
}
