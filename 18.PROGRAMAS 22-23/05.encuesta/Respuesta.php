<?php
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

 
/**
 * @ORM\Entity
 * @ORM\Table(name="respuestas")
 */
 
class Respuesta
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $respuesta;
	
	/**
     * @ORM\ManyToOne(targetEntity="Pregunta", inversedBy="respuestas")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     */
	protected $pregunta;
 
	/**
     * @ORM\OneToMany(targetEntity="Resultado", mappedBy="respuesta")
     */
	protected $resultados;
	
	public function __construct()
                                                                                                                            {
                                                                                                                                $this->resultados = new ArrayCollection();
                                                                                                                            }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRespuesta(string $respuesta): self
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setPregunta(?Pregunta $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function addResultado(Resultado $resultado): self
    {
        if (!$this->resultados->contains($resultado)) {
            $this->resultados[] = $resultado;
            $resultado->setRespuesta($this);
        }

        return $this;
    }

    public function removeResultado(Resultado $resultado): self
    {
        if ($this->resultados->contains($resultado)) {
            $this->resultados->removeElement($resultado);
            // set the owning side to null (unless already changed)
            if ($resultado->getRespuesta() === $this) {
                $resultado->setRespuesta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resultado[]
     */
    public function getResultados(): Collection
    {
        return $this->resultados;
    }
}
