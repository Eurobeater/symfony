<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
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
    private $evento;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    /**
     * @ORM\ManyToOne(targetEntity=Entidad::class, inversedBy="eventos")
     */
    private $entidad;

    /**
     * @ORM\ManyToOne(targetEntity=Categoria::class, inversedBy="eventos")
     */
    private $categoria;

    //ORM\Column(type="boolean",options={"default"= 0},nullable=true)
    /**
     * @ORM\Column(type="boolean",options={"default"= 0},nullable=true)
     */
    private $validado;

    public function getId(): ?string
    {
        return $this->id;
    }
    
    public function getEvento(): ?string
    {
        return $this->evento;
    }

    public function setEvento(string $evento): self
    {
        $this->evento = $evento;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getEntidad(): ?Entidad
    {
        return $this->entidad;
    }

    public function setEntidad(?Entidad $entidad): self
    {
        $this->entidad = $entidad;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function isValidado(): ?bool
    {
        return $this->validado;
    }

    public function setValidado(bool $validado): self
    {
        $this->validado = $validado;

        return $this;
    }

    
}
