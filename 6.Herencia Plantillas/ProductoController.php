<?php
// src/Controller/ProductoController.php

namespace App\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// tipos form
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

// clase
use App\Entity\Product;
// form
use App\Form\ProductType;


// Constraints
use Symfony\Component\Validator\Constraints\Currency;


/**
 * @Route("/plantilla")
 */
class ProductoController extends Controller
{
    /**
     * @Route("/plantilla", name="plantilla")
     */
    public function plantilla() 
	{	
        $productos = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();
         
		
		return $this->render('plantilla/prueba.html.twig' , array('productos' => $productos));
	}
    
    
}
