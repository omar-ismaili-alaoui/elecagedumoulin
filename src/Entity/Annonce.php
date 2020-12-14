<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 */
class Annonce
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre de l'annonce est obligtoire")
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="Format erroné")
     */
    private $datePublished;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity=AnnonceImage::class, mappedBy="annonce")
     */
    private $annonceImages;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class, cascade={"persist", "remove"})
     */
    private $race;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vermifuge;

    /**
     * @ORM\Column(type="boolean")
     */
    private $taouage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vaccined;

    /**
     * @ORM\Column(type="boolean")
     */
    private $loof;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDispo;

    /**
     * @ORM\Column(type="integer")
     */
    private $portee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $certificat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nbTatouage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPortee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function __construct()
    {
        $this->annonceImages = new ArrayCollection();
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

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished(\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    /**
     * @return Collection|AnnonceImage[]
     */
    public function getAnnonceImages(): Collection
    {
        return $this->annonceImages;
    }

    public function addAnnonceImage(AnnonceImage $annonceImage): self
    {
        if (!$this->annonceImages->contains($annonceImage)) {
            $this->annonceImages[] = $annonceImage;
            $annonceImage->setAnnonce($this);
        }

        return $this;
    }

    public function removeAnnonceImage(AnnonceImage $annonceImage): self
    {
        if ($this->annonceImages->removeElement($annonceImage)) {
            // set the owning side to null (unless already changed)
            if ($annonceImage->getAnnonce() === $this) {
                $annonceImage->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getRace(): ?Race
    {
        return $this->race;
    }

    public function setRace(?Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getVermifuge(): ?bool
    {
        return $this->vermifuge;
    }

    public function setVermifuge(bool $vermifuge): self
    {
        $this->vermifuge = $vermifuge;

        return $this;
    }

    public function getTaouage(): ?bool
    {
        return $this->taouage;
    }

    public function setTaouage(bool $taouage): self
    {
        $this->taouage = $taouage;

        return $this;
    }

    public function getVaccined(): ?bool
    {
        return $this->vaccined;
    }

    public function setVaccined(bool $vaccined): self
    {
        $this->vaccined = $vaccined;

        return $this;
    }

    public function getLoof(): ?bool
    {
        return $this->loof;
    }

    public function setLoof(bool $loof): self
    {
        $this->loof = $loof;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->dateDispo;
    }

    public function setDateDispo(\DateTimeInterface $dateDispo): self
    {
        $this->dateDispo = $dateDispo;

        return $this;
    }

    public function getPortee(): ?int
    {
        return $this->portee;
    }

    public function setPortee(int $portee): self
    {
        $this->portee = $portee;

        return $this;
    }

    public function getCertificat(): ?bool
    {
        return $this->certificat;
    }

    public function setCertificat(bool $certificat): self
    {
        $this->certificat = $certificat;

        return $this;
    }

    public function getNbTatouage(): ?string
    {
        return $this->nbTatouage;
    }

    public function setNbTatouage(string $nbTatouage): self
    {
        $this->nbTatouage = $nbTatouage;

        return $this;
    }

    public function getIsPortee(): ?bool
    {
        return $this->isPortee;
    }

    public function setIsPortee(bool $isPortee): self
    {
        $this->isPortee = $isPortee;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
