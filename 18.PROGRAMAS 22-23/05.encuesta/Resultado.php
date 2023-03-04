<?php
namespace App\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="resultados")
 */
 
class Resultado
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    
	/**
     * @ORM\ManyToOne(targetEntity="Respuesta", inversedBy="resultados")
     * @ORM\JoinColumn(name="respuesta_id", referencedColumnName="id")
     */
	protected $respuesta;

   	public function __construct()
    {
        $this->respuesta = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setRespuesta(?Respuesta $respuesta): self
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    public function getRespuesta(): ?Respuesta
    {
        return $this->respuesta;
    }
}
