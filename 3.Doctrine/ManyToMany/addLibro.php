public function addLibro()
    {
        
        $entityManager = $this->getDoctrine()->getManager();

        $libro = new Libro();
        $libro->setTitulo('2001 Una odisea en el espacio');
        
        $autor = new Autor();
        $autor->setName('Arthur C. Clarke');
        
        $libro->addAutor( $autor);
        

        
        $entityManager->persist( $libro);
        $entityManager->persist( $autor);
   
        $entityManager->flush();

        return new Response('Saved ' );
    }
