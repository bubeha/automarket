<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{

    /**
     * @var AuthService
     */
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(
        LoginRequest $request
    ): JsonResponse {
        $credentials = $request->validated();
        $credentials['email.email'] = $credentials['email'];

        unset($credentials['email']);

        return $this->service->authorize($credentials);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->service->logout();
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        return $this->service->refreshToken();
    }

    /**
     * @param Authenticatable $user
     * @param ResponseFactory $response
     * @return JsonResponse
     */
    public function getAccountData(Authenticatable $user, ResponseFactory $response): JsonResponse
    {
        return $response->json($user);
    }
}
