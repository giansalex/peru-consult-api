<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $path = $event->getRequest()->getPathInfo();

        $isApi = substr($path, 0, 4) === '/api';
        if (!$isApi) {
            return;
        }

        $token = $event->getRequest()->query->get('token');
        if ($token !== $this->token) {
            throw new AccessDeniedHttpException('This action needs a valid token!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
