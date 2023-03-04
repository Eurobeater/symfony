<?php
// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/product")
*/
class ProductController extends AbstractController
{
	/**
    * @Route("/create", name="product_create")
    */
	
	public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Pantalla');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        $entityManager->persist($product);
        $entityManager->flush();

		//$product->add();
        return new Response('Saved new product with id '.$product->getId());
    }
	/**
    * @Route("/read/{id}", name="product_read")
    */
	public function read(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
	
	
	/**
    * @Route("/delete/{id}", name="product_delete")
    */
	public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
		$entityManager = $doctrine->getManager();
		$entityManager->remove($product);
		$entityManager->flush($product);
        return new Response('Borrado');

    }
	/**
    * @Route("/update/{id}", name="product_update")
    */
	 public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
		$product->setName('Teclado');
		$entityManager = $doctrine->getManager();
		$entityManager->persist($product);
		$entityManager->flush($product);
        return new Response('Actualizado');

    }
	
}