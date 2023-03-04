<?php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
 
use Doctrine\Common\Collections\ArrayCollection;


 
/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $products;
 
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="text")
     */
    protected $description;

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

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Product
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Product
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set descriccion
     *
     * @param string $descriccion
     * @return Product
     */
    public function setDescriccion($descriccion)
    {
        $this->descriccion = $descriccion;

        return $this;
    }

    /**
     * Get descriccion
     *
     * @return string 
     */
    public function getDescriccion()
    {
        return $this->descriccion;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }
	
	    /**
     * Set family
     *
     * @param integer $family
     * @return Product
     */
    public function setCategory($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return integer 
     */
    public function getFamily()
    {
        return $this->family;
    }
}
