<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthorizeService
 * @package App\Services
 */
class AuthService
{
    /**
     * @var Guard
     */
    private $guard;
    /**
     * @var ResponseFactory
     */
    private $response;
    /**
     * @var Translator
     */
    private $translator;

    /**
     * AuthorizeService constructor.
     * @param Guard $guard
     * @param ResponseFactory $response
     * @param Translator $translator
     */
    public function __construct(
        Guard $guard,
        ResponseFactory $response,
        Translator $translator
    ) {
        $this->guard = $guard;
        $this->response = $response;
        $this->translator = $translator;
    }

    /**
     * @param array $credentials
     * @return JsonResponse
     */
    public function authorize(array $credentials): JsonResponse
    {
        $token = $this->guard->attempt($credentials);

        if (! $token) {
            return $this->response->json([
                'message' => $this->translator->get('auth.failed'),
            ], 401);
        }

        return $this->respondWithToken($token, $this->guard->factory()->getTTL());
    }

    /**
     * @param string $token
     * @param int $minutes
     * @return JsonResponse
     */
    protected function respondWithToken(string $token, int $minutes): JsonResponse
    {
        return $this->response->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $minutes * 60,
        ], 200);
    }
}
