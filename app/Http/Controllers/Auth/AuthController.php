<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthorizationTokenNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /** @var AuthService */
    private $service;

    /** @var ResponseFactory */
    private $response;

    /** @var Translator */
    private $translator;

    public function __construct(
        AuthService $service,
        ResponseFactory $response,
        Translator $translator
    ) {
        $this->service = $service;
        $this->response = $response;
        $this->translator = $translator;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->getCredentials();

        try {
            $result = $this->service->authorize($credentials);
        } catch (AuthorizationTokenNotFound $exception) {
            return $this->response->json([
                'message' => $this->translator->get('auth.failed'),
            ], 401);
        }

        return $this->response
            ->json($result);
    }

    /**
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = $this->service->registerUser($data);

        return $this->response
            ->json($result);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->service->logout();

        return $this->response
            ->json([
                'message' => $this->translator->get('auth.logout'),
            ]);
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $result = $this->service->refreshToken();

        return $this->response
            ->json($result);
    }

    /**
     * @param Authenticatable $user
     * @return JsonResponse
     */
    public function getAccountData(Authenticatable $user): JsonResponse
    {
        return $this->response
            ->json([
                'user' => $user,
            ]);
    }
}
