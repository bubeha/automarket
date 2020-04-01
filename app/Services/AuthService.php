<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * AuthorizeService constructor.
     * @param Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @param array $credentials
     * @return array
     */
    public function authorize(array $credentials): array
    {
        $token = $this->guard->attempt($credentials);

        if (! $token) {
            throw new UnauthorizedHttpException('Unauthorized.');
        }

        return $this->respondWithToken($token, $this->guard->factory()->getTTL());
    }

    /**
     * @param string $token
     * @param int $minutes
     * @return array
     */
    protected function respondWithToken(string $token, int $minutes): array
    {
        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => $minutes * 60,
        ];
    }
}
