<?php
// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;


/**
* @Route("/task")
*/
class TaskController extends AbstractController
{
    /**
     * @Route("/new", name="task_new" )
     */public function new(Request $request): Response
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class, array(
       'constraints' => array(
           new NotBlank(),
           new Length(array('min' => 3)))))
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
			
		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$form->getData() holds the submitted values
            $task = $form->getData();
			
			

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return new Response( "Operacion Realizada" );
        }


        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
	
	
	/**
     * @Route("/new2", name="task_new2" )
     */public function new2(Request $request): Response
    {
        

        $form = $this->createFormBuilder()
            ->add('task', TextType::class, array(
       'constraints' => array(
           new NotBlank(),
           new Length(array('min' => 3)))))
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
			
		$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$form->getData() holds the submitted values
            $task = new Task();
			$datos = $form->getData();
			
			$task->setTask($datos ['task']);
			
			$task->setDueDate(new \DateTime('tomorrow'));
			

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return new Response( "Operacion Realizada" );
        }


        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}