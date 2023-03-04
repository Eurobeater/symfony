<?php
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="encuestas")
 */
 
class Encuesta
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
    protected $name;
	
	/**
     * @ORM\OneToMany(targetEntity="Pregunta", mappedBy="encuesta")
     */
	protected $preguntas;
	
	public function __construct()
                                                                                              {
                                                                                                  $this->preguntas = new ArrayCollection();
                                                                                              }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function addPregunta(Pregunta $pregunta): self
    {
        if (!$this->preguntas->contains($pregunta)) {
            $this->preguntas[] = $pregunta;
            $pregunta->setEncuesta($this);
        }

        return $this;
    }

    public function removePregunta(Pregunta $pregunta): self
    {
        if ($this->preguntas->contains($pregunta)) {
            $this->preguntas->removeElement($pregunta);
            // set the owning side to null (unless already changed)
            if ($pregunta->getEncuesta() === $this) {
                $pregunta->setEncuesta(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pregunta[]
     */
    public function getPreguntas(): Collection
    {
        return $this->preguntas;
    }
}
