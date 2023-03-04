<?php

namespace App\Entity;

use App\Repository\LibroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LibroRepository::class)
 */
class Libro
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
    private $titulo;

    /**
     * @ORM\ManyToMany(targetEntity=Autor::class, inversedBy="libros")
     */
    private $autores;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return Collection|Autor[]
     */
    public function getAutores(): Collection
    {
        return $this->autores;
    }

    public function addAutore(Autor $autore): self
    {
        if (!$this->autores->contains($autore)) {
            $this->autores[] = $autore;
        }

        return $this;
    }

    public function removeAutore(Autor $autore): self
    {
        $this->autores->removeElement($autore);

        return $this;
    }
}
