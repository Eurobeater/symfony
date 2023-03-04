<?php
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="preguntas")
 */
 
class Pregunta
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
    protected $pregunta;
	
	/**
     * @ORM\Column(type="integer")
    */
    protected $orden;
	
	/**
     * @ORM\ManyToOne(targetEntity="Encuesta", inversedBy="preguntas")
     * @ORM\JoinColumn(name="encuesta_id", referencedColumnName="id")
     */
	protected $encuesta;
 
	/**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="pregunta")
     */
	protected $respuestas;
	
	public function __construct()
                                                                                                                                                          {
                                                                                                                                                              $this->respuestas = new ArrayCollection();
                                                                                                                                                          }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setPregunta(string $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getPregunta(): ?string
    {
        return $this->pregunta;
    }

    public function setOrden(int $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setEncuesta(?Encuesta $encuesta): self
    {
        $this->encuesta = $encuesta;

        return $this;
    }

    public function getEncuesta(): ?Encuesta
    {
        return $this->encuesta;
    }

    public function addRespuesta(Respuesta $respuesta): self
    {
        if (!$this->respuestas->contains($respuesta)) {
            $this->respuestas[] = $respuesta;
            $respuesta->setPregunta($this);
        }

        return $this;
    }

    public function removeRespuesta(Respuesta $respuesta): self
    {
        if ($this->respuestas->contains($respuesta)) {
            $this->respuestas->removeElement($respuesta);
            // set the owning side to null (unless already changed)
            if ($respuesta->getPregunta() === $this) {
                $respuesta->setPregunta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Respuesta[]
     */
    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }
}
