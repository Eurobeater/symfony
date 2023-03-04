<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartidoRepository")
 */
class Partido
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

      /**
         * @ORM\ManyToOne(targetEntity="App\Entity\Jornada", inversedBy="partidos")
     */
    private $jornada;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo", inversedBy="partidos_local")
     * @ORM\JoinColumn(nullable=false)
     */
    private $local;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\equipo", inversedBy="partidos_visitante")
    * @ORM\JoinColumn(nullable=false)
     */
    private $visitante;

    /**
     * @ORM\Column(type="integer")
     */
    private $marcador_local;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $marcador_visitante;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?equipo
    {
        return $this->relation;
    }

    public function setRelation(?equipo $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    public function getVisitante(): ?equipo
    {
        return $this->visitante;
    }

    public function setVisitante(?equipo $visitante): self
    {
        $this->visitante = $visitante;

        return $this;
    }

    public function getMarcadorLocal(): ?int
    {
        return $this->marcador_local;
    }

    public function setMarcadorLocal(int $marcador_local): self
    {
        $this->marcador_local = $marcador_local;

        return $this;
    }

    public function getJornada(): ?Jornada
    {
        return $this->jornada;
    }

    public function setJornada(?Jornada $jornada): self
    {
        $this->jornada = $jornada;

        return $this;
    }

    public function getLocal(): ?equipo
    {
        return $this->local;
    }

    public function setLocal(?equipo $local): self
    {
        $this->local = $local;

        return $this;
    }

    public function getMarcadorVisitante(): ?int
    {
        return $this->marcador_visitante;
    }

    public function setMarcadorVisitante(int $marcador_visitante): self
    {
        $this->marcador_visitante = $marcador_visitante;

        return $this;
    }
}
