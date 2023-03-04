<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JornadaRepository")
 */
class Jornada
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $jornada;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partido", mappedBy="jornada")
     */
    private $partidos;

    public function __construct()
    {
        $this->partidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJornada(): ?int
    {
        return $this->jornada;
    }

    public function setJornada(int $jornada): self
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * @return Collection|Partido[]
     */
    public function getPartidos(): Collection
    {
        return $this->partidos;
    }

    public function addPartido(Partido $partido): self
    {
        if (!$this->partidos->contains($partido)) {
            $this->partidos[] = $partido;
            $partido->setJornada($this);
        }

        return $this;
    }

    public function removePartido(Partido $partido): self
    {
        if ($this->partidos->contains($partido)) {
            $this->partidos->removeElement($partido);
            // set the owning side to null (unless already changed)
            if ($partido->getJornada() === $this) {
                $partido->setJornada(null);
            }
        }

        return $this;
    }
}
