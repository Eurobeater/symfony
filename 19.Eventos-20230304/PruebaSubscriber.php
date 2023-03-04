<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

use App\Repository\LogRepository;
use App\Entity\Log;

class PruebaSubscriber implements EventSubscriberInterface
{
    private $logRepository;
    
    public function __construct( LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }
    public function onKernelRequest(RequestEvent $event): void
    {
        $log = new Log();
        $log->setUrl( $event->getRequest() );
        $log->setFecha(new \DateTime ());
        $log->setHora(new \DateTime ());
        $this->logRepository->save( $log, true );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
