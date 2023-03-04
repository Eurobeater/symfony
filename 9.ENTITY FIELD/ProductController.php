<?php
// src/Controller/ProductoController.php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// tipos form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

// clase
use App\Entity\Product;
// form
use App\Form\Product2Type;


// Constraints
use Symfony\Component\Validator\Constraints\Currency;


/**
 * @Route("/producto")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/test1", name="producto_test1")
     */
    public function test1( Request $request)
    {
       
        $producto = new Product();
        $form = $this->createForm(Product2Type::class, $producto );
       
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();
         
            return new Response( "Save");
        }
        else
            return $this->render('product/form.html.twig', array('form' => $form->createView(),));
    }
    
    
    /**
     * @Route("/test1", name="producto_test2")
     */
     public function test2( Request $request, $id )
    {
       
        $producto = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findOneById( $id );
		
        $form = $this->createForm(Product2Type::class, $producto );
       
        $form->handleRequest( $request );

         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();
         
            return new Response( "Save");
        }
        else
            return $this->render('product/form.html.twig', array('form' => $form->createView(),));
    }
    
    
}
