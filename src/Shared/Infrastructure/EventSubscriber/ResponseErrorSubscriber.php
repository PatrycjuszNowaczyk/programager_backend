<?php

namespace App\Shared\Infrastructure\EventSubscriber;

use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This subscriber is used to hide the exception message in production.
 * It is used to avoid leaking sensitive information.
 */
final readonly class ResponseErrorSubscriber implements EventSubscriberInterface {

    public function __construct(
        private KernelInterface $kernel
    ) {
    }

    public static function getSubscribedEvents(): array {
        // High priority so it runs before the default exception listener
        return [ KernelEvents::EXCEPTION => [ 'onException', 256 ] ];
    }

    /**
     * Hide the exception message in production.
     *
     * @param ExceptionEvent $event
     *
     * @return void
     */
    public function onException( ExceptionEvent $event ): void {

        if ( 'dev' === $this->kernel->getEnvironment() ) {
            return;
        }


        $request = $event->getRequest();

        // Only apply to /api and /api/* paths
        $path = $request->getPathInfo();
        if ( !str_starts_with( $path, '/api' ) ) {
            return;
        }

        $e = $event->getThrowable();


        // Unknown path -> empty 404
        if ( $e instanceof NotFoundHttpException ) {
            $event->setResponse( new Response( '', 404 ) );

            return;
        }

        // Existing path but wrong method -> hide as 404 (or use 405 if you prefer)
        if ( $e instanceof MethodNotAllowedHttpException ) {
            $event->setResponse( new Response( '', 404 ) );

            return;
        }

        // Any other HttpException on /api -> same status, empty body
        if ( $e instanceof HttpExceptionInterface ) {
            $event->setResponse( new Response( '', $e->getStatusCode(), $e->getHeaders() ) );
        }

        // Any other exception on /api -> empty 404
        if ( $e instanceof Exception ) {
            $event->setResponse( new Response( '', 404 ) );
        }
    }
}
