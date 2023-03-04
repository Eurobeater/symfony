<?php
// src/Controller/TeamController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Team;
use App\Entity\Player;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/team")
*/
class TeamController extends AbstractController
{
	/**
    * @Route("/create", name="team_create")
    */
	
	public function createTeam(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

		$player = $doctrine->getRepository(Player::class)->find(2);
        
		$team = new Team();
        $team->setName('Alemania');
	  
		$team->addPlayer( $player );
	   
        $entityManager->persist($team);
        $entityManager->flush();

		//$team->add();
        return new Response('Saved new team with id '.$team->getId());
    }
	
	
}