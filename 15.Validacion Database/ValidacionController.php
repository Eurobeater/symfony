<?php

// src/Controller/MovilController.php

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


// clase
use App\Entity\Movil;

// form
use App\Form\MovilType;

// constraint
use App\Validator\Constraints\ZipDatabase;
use App\Validator\Constraints\TelefonoMovil;

/**
 * @Route("/validacion")
*/
class ValidacionController extends AbstractController
{
    
    
   
   
    /**
     * @Route("/usuario", name="validacion_usuario")
     */
    public function usuario( Request $request )
    {
        
         $form = $this->createFormBuilder()
             ->add('nombre', TextType::class)
			  ->add('telefono', TextType::class, ['constraints' => [new TelefonoMovil()]])
			  ->add('cp', TextType::class, ['constraints' => [new ZipDatabase()] ])
      
            ->add('send', SubmitType::class)
            ->getForm();
        
		$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
			
            return new Response( "Save");
        }
        else
            return $this->render('form.html.twig', array('form' => $form->createView(),));
    }
    
   
    
}
