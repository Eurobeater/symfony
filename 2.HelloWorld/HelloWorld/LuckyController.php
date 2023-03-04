<?php
// src/Controller/LuckyController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Response;

class LuckyController extends AbstractController
{
    
	public function prueba()
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', array( 'number' => $number ));
    }
	
	

}