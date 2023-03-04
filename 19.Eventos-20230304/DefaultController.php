<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Event\SampleEvent;
use App\EventSubscriber\SampleSubscriber;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(EventDispatcherInterface $dispatcher)
    {
        $event = new SampleEvent("route=>default");
        $dispatcher->dispatch($event, SampleEvent::NAME);

        var_dump("prueba_event");
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}