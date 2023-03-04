<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LibroRepository")
 */
class Libro
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
    private $titulo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Autor", inversedBy="libros")
     */
    private $autores;

    public function __construct()
    {
        $this->autores = new ArrayCollection();
    }
    public function __toString() {
        return $this->getTitululo();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * @return Collection|Autor[]
     */
    public function getAutors(): Collection
    {
        return $this->autores;
    }

    public function addAutor(Autor $autor): self
    {
        if (!$this->autores->contains($autor)) {
            $this->autores[] = $autor;
        }

        return $this;
    }

    public function removeAutor(Autor $autor): self
    {
        if ($this->autores->contains($autor)) {
            $this->autores->removeElement($autor);
        }

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
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
        if ($this->autores->contains($autore)) {
            $this->autores->removeElement($autore);
        }

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }
}
