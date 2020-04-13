<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\FullName;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Ramsey\Uuid\Uuid;

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
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $credentials['email.email'] = $credentials['email'];

        unset($credentials['email']);

        return $this->service->authorize($credentials);
    }

    /**
     * @param RegistrationRequest $request
     * @return void
     */
    public function register(RegistrationRequest $request)
    {
        $data = $request->validated();

        $em = app(EntityManagerInterface::class);

        $fullName = new FullName($data['first_name'], $data['last_name']);
        $email = new Email($data['email']);

        $user = new User(Uuid::uuid4(), $fullName, $email, $data['password']);

        $em->persist($user);
        $em->flush();
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
