<?php

declare( strict_types = 1 );

namespace App\Manager\User\Infrastructure\Controller\V1;

use App\Manager\User\Application\Command\RegisterUserCommand;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route( '/v1/users' )]
final class V1UserController extends AbstractController {

    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
    }

    #[Route( '', name: 'get_users', methods: [ 'GET' ] )]
    public function get_users(): JsonResponse {

        return new JsonResponse( [
            'message' => 'List all users',
        ] );
    }

    #[Route( '', name: 'add_user', methods: [ 'POST' ] )]
    public function add_user( Request $request ): JsonResponse {
        try {
            $data = json_decode( $request->getContent(), true );

            $command = new RegisterUserCommand( $data['email'], $data['password'] );

            $envelope = $this->bus->dispatch( $command );
        } catch ( Exception $e ) {
            return new JsonResponse( [
                'message' => 'Error creating a new user',
                'error'   => $e->getMessage()
            ], 400 );
        }

        return new JsonResponse( [
            'message' => 'Creating a new user',
            'data' => $envelope->getMessage()
        ], 201 );


        //TODO return only status code 201
//        return new Response( null, Response::HTTP_CREATED );
    }

    #[Route( '/{id}', name: 'get_user', requirements: [ 'id' => '\d+' ], methods: [ 'GET' ] )]
    public function get_user( int $id ): JsonResponse {

        return new JsonResponse( [
            'message' => 'This is the user with id',
            'id'      => $id
        ] );
    }

    #[Route( '/{id}', name: 'update_user', requirements: [ 'id' => '\d+' ], methods: [ 'PUT' ] )]
    public function update_user( int $id ): JsonResponse {

        return new JsonResponse( [
            'message' => 'Updating the user with id',
            'id'      => $id
        ] );
    }

    #[Route( '/login', name: 'login', methods: [ 'POST' ] )]
    public function login(): JsonResponse {
        return new JsonResponse( [
            'message' => 'Login user',
        ] );
    }

    #[Route( '/logout', name: 'logout', methods: [ 'POST' ] )]
    public function logout(): JsonResponse {
        return new JsonResponse( [
            'message' => 'Logout user',
        ] );
    }

    #TODO remember to authenticate the user before deleting it with the token
    #[Route( '/delete', name: 'delete_user', methods: [ 'DELETE' ] )]
    public function delete_user(): JsonResponse {
        return new JsonResponse( [
            'message' => 'Deleting the user'
        ] );
    }
}
