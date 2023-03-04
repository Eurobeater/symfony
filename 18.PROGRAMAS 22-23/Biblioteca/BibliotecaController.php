<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Autor;
use App\Entity\Libro;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/biblioteca")
 */
class BibliotecaController extends AbstractController
{

    /**
     * @Route("/listar_libros",  name="listar_libros")
     */
    public function listarLibros()
    {
        $libros = $this->getDoctrine()
            ->getRepository(Libro::class)
            ->findAll();

        if (!$libros) {
            throw $this->createNotFoundException(
                'No product found for id ');
        }

        return $this->render('biblioteca/listar_libros.html.twig', array('libros' => $libros));
    }

    /**
     * @Route("/editLibro/{id}/{search}", defaults={"search" = null }, name="editLibro")
     */
    public function editLibro(Request $request, $id, $search)
    {

        $session = $request->getSession();

        $libro = $this->getDoctrine()
            ->getRepository(Libro::class)
            ->findOneById($id);

        if (!$libro) {
            throw $this->createNotFoundException(
                'No item found for id ');
        }

        if (!$session->get('edit_id') || $session->get('edit_id') != $id) {
            $session->set('edit_id', $id);

            $autores = array();
            foreach ($libro->getAutores() as $item) {
                $autores[] = array('id' => $item->getId(), 'name' => $item->getName());
            }
            $session->set('edit_autores', $autores);

        }

        // Lista de autores
        $lista = array();

        foreach ($session->get('edit_autores') as $item) {

            $lista[$item['name']] = $item['id'];
        }

        // lista de escritores
        if (isset($search)) {
           
            $cadena = '%' . $search . '%';
            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("SELECT n FROM App:Autor n WHERE n.name LIKE :searchterm ")
                ->setParameter('searchterm', $cadena);

            $autores = $query->getResult();
        } else {
            $autores = $this->getDoctrine()
                ->getRepository(Autor::class)
                ->findAll();
        }

        $list = array();
        foreach ($autores as $item) {
            $list[$item->getName()] = $item->getId();
        }

        $form = $this->createFormBuilder();
        $form->add('id', TextType::class, ['data' => $libro->getId()]);
        $form->add('titulo', TextType::class, ['data' => $libro->getTitulo()]);
        $form->add('autores', ChoiceType::class, ['choices' => $lista, 'multiple' => true, 'required' => false]);

        $form->add('Search', TextType::class, ['data' => isset($search) ? $search : '', 'required' => false]);
        
        $form->add('escritores', ChoiceType::class, ['choices' => $list, 'multiple' => true, 'required' => false]);

        $form->add('Add', SubmitType::class);
        $form->add('Remove', SubmitType::class);
        $form->add('Buscar', SubmitType::class);
        $form->add('Save', SubmitType::class);
        $form->add('Delete', SubmitType::class);
        $form = $form->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $libro->setTitulo($data['titulo']);

            if ($form->get('Add')->isClicked()) {
                foreach ($data['escritores'] as $item) {
                    $autor = $this->getDoctrine()
                        ->getRepository(Autor::class)
                        ->findOneById($item);

                    $autores = $session->get('edit_autores');
                    $autores[] = array('id' => $autor->getId(), 'name' => $autor->getName());
                    $session->set('edit_autores', $autores);
                }
                
                return $this->redirectToRoute('editLibro', ['id' => $data['id']]);

            } elseif ($form->get('Remove')->isClicked()) {
                
                $posiciones = array();
                foreach ($data['autores'] as $item) {
                    $pos = 0;
                    foreach ($session->get('edit_autores') as $elemento) {
                        printf("</br> %s [%s] [%s]</br> ", $pos, $elemento['id'], $item);
                         if ($elemento['id'] == $item) {
                            printf("</br> %s [%s] [%s] ok</br> ", $pos, $elemento['id'], $item);
                            $posiciones[] = $pos;
                        }
                        $pos++;
                    }
                }
                //die();
                $autores = $session->get('edit_autores');
                foreach ($posiciones as $pos) {
                    unset($autores[$pos]);
                }
                $session->set('edit_autores', $autores);
                return $this->redirectToRoute('editLibro', ['id' => $data['id']]);
            } elseif ($form->get('Buscar')->isClicked()) {
                return $this->redirectToRoute('editLibro', ['id' => $data['id'], 'search' => $data['Search']]);
            } elseif ($form->get('Delete')->isClicked()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($libro);
                $em->flush();
                return $this->redirectToRoute('listar_libros');
            } elseif ($form->get('Save')->isClicked()) {
                $posiciones = array();
                $pos = 0;
                // Borra los autores que no estan en sesion
                foreach ($libro->getAutores() as $item) {
                    if (!in_array($item->getId(), $session->get('edit_autores'))) {
                        $posiciones[] = $pos;
                        $pos++;
                    }
                }
                arsort($posiciones); // orden inverso posiciones
                foreach ($posiciones as $pos) {
                    $libro->getAutores()->remove($pos);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($libro);
                }

                // Añade los autores que estan en sesion
                foreach ($session->get('edit_autores') as $item) {
                    $autor = $this->getDoctrine()
                        ->getRepository(Autor::class)
                        ->findOneById($item['id']);
                    if (!$libro->getAutores()->contains($autor)) {
                        $libro->addAutor($autor);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($libro);
                    }
                }

                // Borro Sesion
                //$session->clear();
                $session->remove('edit_autores');
                $session->remove('edit_id');

                $em = $this->getDoctrine()->getManager();
                $em->persist($libro);

                $em->flush();
                return $this->redirectToRoute('listar_libros');

            }

        } else {
            return $this->render('biblioteca/libro.html.twig', array('form' => $form->createView(), "libro" => $libro));
        }

    }

    /**
     * @Route("/newLibro/{search}", defaults={"search" = null }, name="newLibro")
     */
    public function newLibro(Request $request, $search)
    {

        $session = $request->getSession();

        if ($session->get('new_libro') == null) {
            $libro = new Libro();
            $session->set('new_libro', $libro);
            $session->set('new_autores', array());
        } else {
            $libro = $session->get('new_libro');
        }

        $lista = array();
        // Lista de autores
        if ($session->get('new_autores') != null) {
            foreach ($session->get('new_autores') as $item) {
                $lista[$item['name']] = $item['id'];
            }
        }

        // lista de escritores
        if (isset($search)) {
            $cadena = '%' . $search . '%';
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery("SELECT n FROM App:Autor n WHERE n.name LIKE :searchterm ")
                ->setParameter('searchterm', $cadena);
            $escritores = $query->getResult();
        } else {
            $escritores = $this->getDoctrine()
                ->getRepository(Autor::class)
                ->findAll();
        }

        $list = array();
        foreach ($escritores as $item) {
            $list[$item->getName()] = $item->getId();
        }

        $form = $this->createFormBuilder();
        $form->add('id', TextType::class, ['required' => false]);
        $form->add('titulo', TextType::class, ['data' => $libro->getTitulo()]);
        $form->add('autores', ChoiceType::class, ['choices' => $lista, 'multiple' => true, 'required' => false]);
        $form->add('escritores', ChoiceType::class, ['choices' => $list, 'multiple' => true, 'required' => false]);

        $form->add('Search', TextType::class, ['data' => isset($search) ? $search : '', 'required' => false]);

        $form->add('Add', SubmitType::class);
        $form->add('Remove', SubmitType::class);
        $form->add('Buscar', SubmitType::class);
        $form->add('Save', SubmitType::class);
        $form = $form->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $libro->setTitulo($data['titulo']);
            if ($form->get('Add')->isClicked()) {
                foreach ($data['escritores'] as $item) {
                    $autor = $this->getDoctrine()
                        ->getRepository(Autor::class)
                        ->findOneById($item);
                    $autores = $session->get('new_autores');
                    $autores[] = array('id' => $autor->getId(), 'name' => $autor->getName());
                    $session->set('new_autores', $autores);
                }
                $session->set('libro', $libro);
                return $this->redirectToRoute('newLibro');
            } elseif ($form->get('Remove')->isClicked()) {
                
                $posiciones = array();
                foreach ($data['autores'] as $item) {

                    $pos = 0;
                    foreach ($session->get('new_autores') as $elemento) {
                       
                        if ($item == $elemento['id']) {
                            $posiciones[] = $pos;
                        }
                        $pos++;
                    }
                }
                $autores = $session->get('new_autores');
                foreach ($posiciones as $pos) {
                    unset($autores[$pos]);
                }
                $session->set('new_autores', $autores);
                $session->set('new_libro', $libro);
                return $this->redirectToRoute('newLibro');
            } elseif ($form->get('Buscar')->isClicked()) {
                $session->set('new_libro', $libro);
                return $this->redirectToRoute('newLibro', ['search' => $data['Search']]);
            } elseif ($form->get('Save')->isClicked()) {

                // Añade los autores que estan en sesion
                foreach ($session->get('new_autores') as $item) {
                    $autor = $this->getDoctrine()
                        ->getRepository(Autor::class)
                        ->findOneById($item['id']);
                    $libro->addAutor($autor);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($autor);
                    $em->persist($libro);
                }
            }

            // Borro Sesion
            //$session->clear();
            $session->remove('new_autores');
            $session->remove('new_libro');

     
            $em = $this->getDoctrine()->getManager();
            $em->persist($libro);
            $em->flush();

            return $this->redirectToRoute('listar_libros');

        } else {
            return $this->render('biblioteca/libro.html.twig', array( 'libro' => $libro, 'form' => $form->createView()));
        }

    }

    /**
     * @Route("/error/{error}", defaults={"error" = null }, name="libro_error")
     */
    public function error($error)
    {
      
        return $this->render('biblioteca/error.html.twig');
    }

}
