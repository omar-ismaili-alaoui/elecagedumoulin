<?php

namespace App\Entity;

use App\Repository\BdgAnnonceImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BdgAnnonceImageRepository::class)
 */
class BdgAnnonceImage
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
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $principal;

    /**
     * @ORM\ManyToOne(targetEntity=BdgAnnonce::class, inversedBy="bdgAnnonceImages")
     */
    private $bdgAnnonceId;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPrincipal(): ?bool
    {
        return $this->principal;
    }

    public function setPrincipal(bool $principal): self
    {
        $this->principal = $principal;

        return $this;
    }

    public function getBdgAnnonceId(): ?BdgAnnonce
    {
        return $this->bdgAnnonceId;
    }

    public function setBdgAnnonceId(?BdgAnnonce $bdgAnnonceId): self
    {
        $this->bdgAnnonceId = $bdgAnnonceId;

        return $this;
    }

}
