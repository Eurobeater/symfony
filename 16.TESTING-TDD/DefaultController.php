<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use App\Service\ContactsInfoManager;

use App\Helper\PorcentajeHelper;

class DefaultController extends AbstractController
{
   
    /**
     * @Route("/myprueba", name="default")
     */
    public function myprueba(Request $request)
    {
        $contactForm = $this->createForm(ContactType::class);

        if ($request->isMethod('POST')) {
            $contactForm->handleRequest($request);

            var_dump($contactForm->getData());

            $name = $contactForm->getData()['name'];
            $message = $contactForm->getData()['message'];
           
            
            return $this->render('default/myprueba.html.twig', [
            'name' => $name,
            'message' => $message,
            'contactForm' => $contactForm->createView(),
            ]);
           
            
           
        }

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'contactForm' => $contactForm->createView(),
        ]);
    }
    
     /**
     * @Route("/porcentaje", name="porcentaje")
     */
    public function porcentaje()
    {
        
        $valor = 100;
		
		$porcentaje = 10;
		
						
		$value = PorcentajeHelper::porcentaje( $valor, $porcentaje);
        
        return new Response( $value );
    }
}