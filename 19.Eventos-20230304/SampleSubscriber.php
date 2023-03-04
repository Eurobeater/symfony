<?php
// EventSubscriber\SampleSubscriber.php

namespace App\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use App\Repository\LogRepository;
use App\Entity\Log;


class SampleSubscriber implements EventSubscriberInterface
{
    private $logRepository;
    
    public function __construct( LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }
    
    public function onSampleEvent($event): void
    {
        touch(__DIR__.'/test.sample.file1');
        $log = new Log();
        $log->setUrl($event->getData() );
        $log->setFecha(new \DateTime ());
        $log->setHora(new \DateTime ());
        $this->logRepository->save( $log, true);
        
    }
    public static function getSubscribedEvents(): array
    {
        return [
            'SampleEvent' => 'onSampleEvent',
        ];
    }
}
