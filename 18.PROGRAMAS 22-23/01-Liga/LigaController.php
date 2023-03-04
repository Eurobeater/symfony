<?php
// src/Controller/LigaController.php

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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

// clase
use App\Entity\Jornada;
use App\Entity\Equipo;
use App\Entity\Partido;



// Constraints
use Symfony\Component\Validator\Constraints\Currency;

/**
 * @Route("/liga")
 */
class LigaController extends Controller
{
    /**
     * @Route("/jornada/{id}", defaults={"id" = 0}, name="jornada")
     */
    public function jornada( Request $request, $id )
    {
        
        $jornadas = $this->getDoctrine()
        ->getRepository(Jornada::class)
        ->findAll();
         
        /*var_dump(serialize( $request));
        var_dump(serialize( $request->get("jornada")));
        */
        
        if( $id != 0 )
            $valor = $id;
        else
        {   
            $valor = 0;
            foreach( $jornadas as $item )
            {
                if( $item->getJornada() > $valor ) 
                    $valor =$item->getJornada();
            }
                
        }
           
            
         $jornada = $this->getDoctrine()
        ->getRepository(Jornada::class)
        ->findOneById(  $valor );
        
        $partidos = $jornada->getPartidos();
        
        $lista = array();
        foreach( $jornadas as $item )
        {
            $lista[ $item->getId() ] =  $item->getId();
        }
        
      
        
        $form = $this->createFormBuilder()
        ->add('jornada',  ChoiceType::class, [
    'choices' => $lista ,  'data'     => $valor ] )
        ->add('Send', SubmitType::class)
        ->getForm();
         
         
              
        $form->handleRequest( $request );

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('jornada', ['id' => $data[ 'jornada' ]]);
        }
        else
            return $this->render('liga/jornada.html.twig', array('form' => $form->createView(), 'partidos' => $partidos ));
    }  
    
    /**
     * @Route("/clasificacion", name="clasificacion")
     */
    public function clasificacion()
    {
        
        $partidos = $this->getDoctrine()
        ->getRepository(Partido::class)
        ->findAll();
         
         $equipos = $this->getDoctrine()
        ->getRepository(Equipo::class)
        ->findAll();
        
        $clasificacion = array();
        foreach(  $equipos  as $item )
        {
            $puntos[ $item->getId() ] = 0;
            $teams[ $item->getId() ] =  $item->getEquipo() ;
            
            
        }
               
        foreach(  $partidos  as $item )
        {
            if( $item->getMarcadorLocal() > $item->getMarcadorVisitante() )
                $puntos[ $item->getLocal()->getId()  ] += 3;
            elseif( $item->getMarcadorLocal() < $item->getMarcadorVisitante() )
                $puntos[ $item->getVisitante()->getId()  ] += 3;
            else
                $puntos[ $item->getLocal()->getId()  ] += 1;
                $puntos[ $item->getVisitante()->getId()  ] += 1;
         }
      
        array_multisort( $puntos, SORT_DESC, $teams );
        $clasificacion = array();
        for( $i = 0; $i < count( $puntos ); $i++ )
        {
            $clasificacion[] = [ 'equipo' => $teams[ $i ],  'puntos' => $puntos[ $i ] ];
        }
        return $this->render('liga/clasificacion.html.twig', ['clasificacion' => $clasificacion ]);
    }
    
    /**
     * @Route("/actualizacion", name="actualizacion")
     */
    public function actualizacion( Request $request )
    {
        
        $jornadas = $this->getDoctrine()
        ->getRepository(Jornada::class)
        ->findAll();
           
        $valor = 0;
        foreach( $jornadas as $item )
        {
            if( $item->getJornada() > $valor ) 
                $valor =$item->getJornada();
        }
        
        $jornada = $this->getDoctrine()
        ->getRepository(Jornada::class)
        ->findOneById(  $valor );
        
        
         $partidos = $this->getDoctrine()
        ->getRepository(Partido::class)
        ->findByJornada(  $valor );
        
        
        
        $formBuilder = $this->createFormBuilder();
        
        foreach( $partidos as $item )
        {
            $formBuilder ->add('partido_local' . $item->getId(),  TextType::class, [
    'label' => $item->getLocal()->getEquipo() ,  'data' =>$item->getMarcadorLocal() ]);
            $formBuilder ->add('partido_visitante' .$item->getId(),  TextType::class, [
    'label' => $item->getVisitante()->getEquipo() ,  'data' =>$item->getMarcadorVisitante() ]);
        
        }
        $formBuilder->add('Send', SubmitType::class);
       
        
        $form = $formBuilder ->getForm();
        
       
       
        $form->handleRequest( $request );
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
           
            foreach( $partidos as $item )
            {   
            
                
                if( isset( $data[ 'partido_local' . $item->getId()])) 
                {
                  
                    $item->setMarcadorLocal( $data[ 'partido_local' . $item->getId()]);
                }
                if( isset( $data[ 'partido_visitante' . $item->getId()])) 
                {
                     $item->setMarcadorVisitante( $data[ 'partido_visitante' . $item->getId()]);
                }
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist( $item );
                $em->flush();
            }
            
            
            return $this->redirectToRoute('actualizacion');
        }
        else
        {
            
            return $this->render('liga/actualizacion.html.twig', array('form' => $form->createView()));
            
        }
    }
}
