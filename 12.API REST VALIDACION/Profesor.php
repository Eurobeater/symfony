<?php

namespace App\Entity;

use App\Repository\ProfesorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfesorRepository::class)
 */
class Profesor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
     private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $papellido;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull
     */
    private $sapellido;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPapellido(): ?string
    {
        return $this->papellido;
    }

    public function setPapellido(string $papellido): self
    {
        $this->papellido = $papellido;

        return $this;
    }

    public function getSapellido(): ?string
    {
        return $this->sapellido;
    }

    public function setSapellido(string $sapellido): self
    {
        $this->sapellido = $sapellido;

        return $this;
    }

    
}
