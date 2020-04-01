<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

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
     * @return array
     */
    public function login(LoginRequest $request): array
    {
        $credentials = $request->validated();
        $credentials['email.email'] = $credentials['email'];

        unset($credentials['email']);

        return $this->service->authorize($credentials);
    }
}
