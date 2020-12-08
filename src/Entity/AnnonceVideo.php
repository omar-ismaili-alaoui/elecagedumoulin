<?php

namespace App\Entity;

use App\Repository\AnnonceVideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnonceVideoRepository::class)
 */
class AnnonceVideo
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
    private $urlCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=AnnonceVideo::class, inversedBy="annonceVideos")
     */
    private $annonce;

    /**
     * @ORM\OneToMany(targetEntity=AnnonceVideo::class, mappedBy="annonce")
     */
    private $annonceVideos;

    public function __construct()
    {
        $this->annonceVideos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlCode(): ?string
    {
        return $this->urlCode;
    }

    public function setUrlCode(string $urlCode): self
    {
        $this->urlCode = $urlCode;

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

    public function getAnnonce(): ?self
    {
        return $this->annonce;
    }

    public function setAnnonce(?self $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAnnonceVideos(): Collection
    {
        return $this->annonceVideos;
    }

    public function addAnnonceVideo(self $annonceVideo): self
    {
        if (!$this->annonceVideos->contains($annonceVideo)) {
            $this->annonceVideos[] = $annonceVideo;
            $annonceVideo->setAnnonce($this);
        }

        return $this;
    }

    public function removeAnnonceVideo(self $annonceVideo): self
    {
        if ($this->annonceVideos->removeElement($annonceVideo)) {
            // set the owning side to null (unless already changed)
            if ($annonceVideo->getAnnonce() === $this) {
                $annonceVideo->setAnnonce(null);
            }
        }

        return $this;
    }
}
