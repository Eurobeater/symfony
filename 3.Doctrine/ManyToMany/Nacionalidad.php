<?php

namespace App\Entity;

use App\Repository\NacionalidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NacionalidadRepository::class)
 */
class Nacionalidad
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
    private $nacionalidad;

    /**
     * @ORM\OneToMany(targetEntity=Autor::class, mappedBy="nacionalidad")
     */
    private $autors;

    public function __construct()
    {
        $this->autors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNacionalidad(): ?string
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(string $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    /**
     * @return Collection|Autor[]
     */
    public function getAutors(): Collection
    {
        return $this->autors;
    }

    public function addAutor(Autor $autor): self
    {
        if (!$this->autors->contains($autor)) {
            $this->autors[] = $autor;
            $autor->setNacionalidad($this);
        }

        return $this;
    }

    public function removeAutor(Autor $autor): self
    {
        if ($this->autors->removeElement($autor)) {
            // set the owning side to null (unless already changed)
            if ($autor->getNacionalidad() === $this) {
                $autor->setNacionalidad(null);
            }
        }

        return $this;
    }
}
