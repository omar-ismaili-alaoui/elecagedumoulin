<?php

namespace App\Entity;

use App\Repository\BdgAnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BdgAnnonceRepository::class)
 */
class BdgAnnonce
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
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $datePublish;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=BdgAnnonceImage::class, mappedBy="bdgAnnonceId")
     */
    private $bdgAnnonceImages;

    public function __construct()
    {
        $this->bdgAnnonceImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDatePublish(): ?\DateTimeInterface
    {
        return $this->datePublish;
    }

    public function setDatePublish(\DateTimeInterface $datePublish): self
    {
        $this->datePublish = $datePublish;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    /**
     * @return Collection|BdgAnnonceImage[]
     */
    public function getBdgAnnonceImages(): Collection
    {
        return $this->bdgAnnonceImages;
    }

    public function addBdgAnnonceImage(BdgAnnonceImage $bdgAnnonceImage): self
    {
        if (!$this->bdgAnnonceImages->contains($bdgAnnonceImage)) {
            $this->bdgAnnonceImages[] = $bdgAnnonceImage;
            $bdgAnnonceImage->setBdgAnnonceId($this);
        }

        return $this;
    }

    public function removeBdgAnnonceImage(BdgAnnonceImage $bdgAnnonceImage): self
    {
        if ($this->bdgAnnonceImages->removeElement($bdgAnnonceImage)) {
            // set the owning side to null (unless already changed)
            if ($bdgAnnonceImage->getBdgAnnonceId() === $this) {
                $bdgAnnonceImage->setBdgAnnonceId(null);
            }
        }

        return $this;
    }
}
