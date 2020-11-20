<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;


class TestEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            TestEvent::NAME => "onTestEvent"
        ];
    }

    public function onTestEvent(TestEvent $e)
    {
        dump($e->getMessage());
        $fs = new Filesystem();
        $fs->appendToFile(
            "/home/ubuntu/tmp/test_event.log", 
            $e->getMessage() . "\n");
    }
}