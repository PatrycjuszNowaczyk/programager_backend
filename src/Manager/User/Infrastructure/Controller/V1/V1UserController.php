<?php

declare( strict_types = 1 );

namespace App\Manager\User\Infrastructure\Controller\V1;

use App\Manager\User\Infrastructure\Dto\UserDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route( '/v1/users' )]
final class V1UserController extends AbstractController {
    #[Route( '/', name: 'get_users', methods: [ 'GET' ] )]
    public function get_users(): JsonResponse {

        return new JsonResponse( [
            'message' => 'List all users',
        ] );
    }

}
