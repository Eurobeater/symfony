<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Repository\ProfesorRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Profesor;
use App\Form\ProfesorType;

/**
 * Class ProfesorController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class ProfesorController extends AbstractController
{
    private $profesorRepository;

    public function __construct(ProfesorRepository $profesorRepository)
    {
        $this->profesorRepository = $profesorRepository;
    }

    /**
     * @Route("profesor", name="add_profesor", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $profesor = new Profesor(); 
                
        $form = $this->createForm(ProfesorType::class, $profesor);
        
        // Decode de JSON input
        $data = json_decode($request->getContent(), true);
        //return new JsonResponse($data, Response::HTTP_CREATED);
       
        // Post the data to the form
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $this->profesorRepository->saveProfesor($profesor);
            return new JsonResponse(['status' => 'Profesor created!'], Response::HTTP_CREATED);
        } else {
            
            $errors = array();
            foreach ($form as $fieldName => $formField) {
                $currentError = $formField->getErrors();

                if ($currentError->current()) {
                    $current = $currentError->current();
                    $errors[$fieldName] = $current->getMessage();
                }
            }

            //$errors = (string) $form->getErrors(true, false);
            return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
            //return new JsonResponse(['status' => 'Error'], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Route("profesor/{id}", name="get_one_profesor", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $profesor = $this->profesorRepository->findOneBy(['id' => $id]);

         if (!$profesor) {
                return new JsonResponse(
                    ['code' => 204, 'message' => 'No profesor found for this query.'],
                    Response::HTTP_NO_CONTENT
                );
        } else {
                $data = [
                'id' => $profesor->getId(),
                'nombre' => $profesor->getNombre(),
                'papellido' => $profesor->getPapellido(),
                'sapellido' => $profesor->getSapellido(),
                ];

            return new JsonResponse($data, Response::HTTP_OK);
        }
    }

    /**
     * @Route("profesores", name="get_all_profesors", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $profesors = $this->profesorRepository->findAll();
        
        
        if (!$profesors) {
                return new JsonResponse(
                    ['code' => 204, 'message' => 'No profesors found for this query.'],
                    Response::HTTP_NO_CONTENT
                );
        } else {
            $data = [];

            foreach ($profesors as $profesor) {
                $data[] =  [
                'id' => $profesor->getId(),
                'nombre' => $profesor->getNombre(),
                'papellido' => $profesor->getPapellido(),
                'sapellido' => $profesor->getSapellido(),
                ];
            }

            return new JsonResponse($data, Response::HTTP_OK);
        }
    }

    /**
     * @Route("profesor/{id}", name="update_profesor", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $profesor = $this->profesorRepository->findOneBy(['id' => $id]);
        if (!$profesor) {
             return new JsonResponse(['status' => 'Error'],  Response::HTTP_NOT_FOUND);
        }else{
            
            $form = $this->createForm(ProfesorType::class, $profesor);
        
            // Decode de JSON input
            $data = json_decode($request->getContent(), true);
            //return new JsonResponse($data, Response::HTTP_CREATED);
       
            // Post the data to the form
            $form->submit($data);

            if ($form->isSubmitted() && $form->isValid()) {
                
                
                $this->profesorRepository->saveProfesor($profesor);
                return new JsonResponse(['status' => 'Profesor created!'], Response::HTTP_CREATED);

                return new JsonResponse(['status' => 'Profesor updated!'], Response::HTTP_OK);
            } 
            else {
            
                $errors = array();
                foreach ($form as $fieldName => $formField) {
                    $currentError = $formField->getErrors();

                    if ($currentError->current()) {
                        $current = $currentError->current();
                        $errors[$fieldName] = $current->getMessage();
                    }
                }

                //$errors = (string) $form->getErrors(true, false);
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
                //return new JsonResponse(['status' => 'Error'], Response::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * @Route("profesor/{id}", name="delete_profesor", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $profesor = $this->profesorRepository->findOneBy(['id' => $id]);
        
        if (!$profesor) {
             return new JsonResponse(['status' => 'Error'],  Response::HTTP_NOT_FOUND);
        }else{
            $this->profesorRepository->removeProfesor($profesor);

            return new JsonResponse(['status' => 'Profesor deleted'], Response::HTTP_OK);
        }
    }
}

?>