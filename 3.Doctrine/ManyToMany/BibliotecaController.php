<?php
// src/Controller/LibroController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Libro;
use App\Entity\Autor;

use Doctrine\ORM\EntityManagerInterface;


/**
* @Route("/biblioteca")
*/
class BibliotecaController extends AbstractController
{
    
	/**
     * @Route("/addLibro", name="biblioteca_addLibro" )
     */
	public function addLibro()
    {
        
        $entityManager = $this->getDoctrine()->getManager();

        $libro = new Libro();
        $libro->setTitulo('2001 Una odisea en el espacio');
        
        $autor = new Autor();
        $autor->setNombre('Arthur');
		 $autor->setApellidos('Clarke');
        
        $libro->addAutore( $autor);
        

        
        $entityManager->persist( $libro);
        $entityManager->persist( $autor);
   
        $entityManager->flush();

        return new Response('Saved ' );
    }
	/**
     * @Route("/libro/{id}", name="biblioteca_libro" )
     */
	public function libro( $id ) {
       
 
        /*
         * Repositorio de la entidad
         * (si no creamos uno y le metemos métodos propios
         * solamente tendrá los métodos de la clase de la entidad)
         */
         $libro = $this->getDoctrine()
        ->getRepository(Libro::class)
        ->find( $id );
		

		if (!$libro) {
        throw $this->createNotFoundException(
            'No product found for id '
        );
		}
		else
		{
			return $this->render('biblioteca/libro.html.twig', [
            'libro' => $libro ]);
		}
    }
	
		/**
     * @Route("/autor/{id}", name="biblioteca_autor" )
     */
	public function autor( $id ) {
       
 
        /*
         * Repositorio de la entidad
         * (si no creamos uno y le metemos métodos propios
         * solamente tendrá los métodos de la clase de la entidad)
         */
         $autor = $this->getDoctrine()
        ->getRepository(Autor::class)
        ->find( $id );
		

		if (!$autor) {
        throw $this->createNotFoundException(
            'No product found for id '
        );
		}
		else
		{
			return $this->render('biblioteca/autor.html.twig', [
            'autor' => $autor ]);
		}
    }
	
	
	
}