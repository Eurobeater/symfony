<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipoRepository")
 */
class Equipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $equipo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partido", mappedBy="relation", orphanRemoval=true)
     */
    private $partidos_local;
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partido", mappedBy="relation", orphanRemoval=true)
     */
    private $partidos_visitante;

    public function __construct()
    {
        $this->partidos_local = new ArrayCollection();
        $this->partidos_visitante = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipo(): ?string
    {
        return $this->equipo;
    }

    public function setEquipo(string $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * @return Collection|Partido[]
     */
    public function getPartidosLocal(): Collection
    {
        return $this->partidos_local;
    }

    public function addPartidosLocal(Partido $partidosLocal): self
    {
        if (!$this->partidos_local->contains($partidosLocal)) {
            $this->partidos_local[] = $partidosLocal;
            $partidosLocal->setRelation($this);
        }

        return $this;
    }

    public function removePartidosLocal(Partido $partidosLocal): self
    {
        if ($this->partidos_local->contains($partidosLocal)) {
            $this->partidos_local->removeElement($partidosLocal);
            // set the owning side to null (unless already changed)
            if ($partidosLocal->getRelation() === $this) {
                $partidosLocal->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Partido[]
     */
    public function getPartidosVisitante(): Collection
    {
        return $this->partidos_visitante;
    }

    public function addPartidosVisitante(Partido $partidosVisitante): self
    {
        if (!$this->partidos_visitante->contains($partidosVisitante)) {
            $this->partidos_visitante[] = $partidosVisitante;
            $partidosVisitante->setRelation($this);
        }

        return $this;
    }

    public function removePartidosVisitante(Partido $partidosVisitante): self
    {
        if ($this->partidos_visitante->contains($partidosVisitante)) {
            $this->partidos_visitante->removeElement($partidosVisitante);
            // set the owning side to null (unless already changed)
            if ($partidosVisitante->getRelation() === $this) {
                $partidosVisitante->setRelation(null);
            }
        }

        return $this;
    }
}
