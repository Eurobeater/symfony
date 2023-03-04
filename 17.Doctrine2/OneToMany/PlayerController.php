<?php
// src/Controller/PlayerController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/player")
*/
class PlayerController extends AbstractController
{
	/**
    * @Route("/create", name="player_create")
    */
	
	public function createPlayer(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

		$team = $doctrine->getRepository(Team::class)->find(1);
        $player = new Player();
        $player->setName('Messi');
		$player->setTeam( $team);
       
	   
	   
        $entityManager->persist($player);
        $entityManager->flush();

		//$player->add();
        return new Response('Saved new player with id '.$player->getId());
    }
	/**
    * @Route("/read/{id}", name="player_read")
    */
	public function read(ManagerRegistry $doctrine, int $id): Response
    {
        $player = $doctrine->getRepository(Player::class)->find($id);

        if (!$player) {
            throw $this->createNotFoundException(
                'No player found for id '.$id
            );
        }

        return new Response('Check out this great player: '.$player->getName());

        // or render a template
        // in the template, print things with {{ player.name }}
        // return $this->render('player/show.html.twig', ['player' => $player]);
    }
	
	
	/**
    * @Route("/delete/{id}", name="player_delete")
    */
	public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $player = $doctrine->getRepository(Player::class)->find($id);

        if (!$player) {
            throw $this->createNotFoundException(
                'No player found for id '.$id
            );
        }
		$entityManager = $doctrine->getManager();
		$entityManager->remove($player);
		$entityManager->flush($player);
        return new Response('Borrado');

    }
	/**
    * @Route("/update/{id}", name="player_update")
    */
	 public function update(ManagerRegistry $doctrine, int $id): Response
    {
        $player = $doctrine->getRepository(Player::class)->find($id);

        if (!$player) {
            throw $this->createNotFoundException(
                'No player found for id '.$id
            );
        }
		$player->setName('Teclado');
		$entityManager = $doctrine->getManager();
		$entityManager->persist($player);
		$entityManager->flush($player);
        return new Response('Actualizado');

    }
	
}