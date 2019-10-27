<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GiftRepository")
 */
class Gift
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Wish", inversedBy="gifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $whish;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Positionning", mappedBy="gift", cascade={"persist", "remove"})
     */
    private $positionning;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWhish(): ?Wish
    {
        return $this->whish;
    }

    public function setWhish(?Wish $whish): self
    {
        $this->whish = $whish;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPositionning(): ?Positionning
    {
        return $this->positionning;
    }

    public function setPositionning(Positionning $positionning): self
    {
        $this->positionning = $positionning;

        // set the owning side of the relation if necessary
        if ($positionning->getGift() !== $this) {
            $positionning->setGift($this);
        }

        return $this;
    }
}
