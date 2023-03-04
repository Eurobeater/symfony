<?php
// src/Controller/LuckyController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;

class LuckyController extends AbstractController
{
    public function number()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
	
	public function prueba()
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', array( 'number' => $number ));
    }
	
	public function par( $valor )
    {
        if( $valor % 2 == 0 )
			$par = true;
		else 
			$par = false;
		
        return $this->render('lucky/par.html.twig', array( 'valor' => $valor, 'par' => $par ));
    }
	
	public function listar() {
       
 
        /*
         * Repositorio de la entidad
         * (si no creamos uno y le metemos métodos propios
         * solamente tendrá los métodos de la clase de la entidad)
         */
         $productos = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();

		if (!$productos) {
        throw $this->createNotFoundException(
            'No product found for id '.$id
        );
    }
 
        return $this->render('lucky/productos.html.twig', array( 'productos' => $productos ));
    }
	
	public function addProducto()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

}