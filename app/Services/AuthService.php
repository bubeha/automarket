<?php

declare(strict_types=1);

namespace App\Services;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\FullName;
use App\Exceptions\AuthorizationTokenNotFound;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Ramsey\Uuid\Uuid;

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
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AuthorizeService constructor.
     * @param Guard $guard
     * @param EntityManagerInterface $em
     */
    public function __construct(
        Guard $guard,
        EntityManagerInterface $em
    ) {
        $this->guard = $guard;
        $this->em = $em;
    }

    /**
     * @param array $credentials
     * @return array
     * @throws AuthorizationTokenNotFound
     */
    public function authorize(array $credentials): array
    {
        $token = $this->guard->attempt($credentials);

        if (! $token) {
            throw new AuthorizationTokenNotFound();
        }

        return $this->createAuthResponse($token);
    }

    /**
     * @param array $data
     * @return array
     */
    public function registerUser(array $data): array
    {
        $fullName = new FullName($data['first_name'], $data['last_name']);
        $email = new Email($data['email']);

        $user = new User(Uuid::uuid4(), $fullName, $email, $data['password']);

        $this->em->persist($user);
        $this->em->flush();

        $token = $this->guard->tokenById($user->getId());

        return $this->createAuthResponse($token);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->guard
            ->logout();
    }

    /**
     * @return array
     */
    public function refreshToken(): array
    {
        $token = $this->guard->refresh();

        return $this->createAuthResponse($token);
    }

    /**
     * @param string $token
     * @param string $tokenType
     * @return array
     */
    private function createAuthResponse(string $token, $tokenType = 'Bearer'): array
    {
        $user = $this->guard->user();

        return [
            'token' => $token,
            'token_type' => $tokenType,
            'expires_in' => config('jwt.ttl') * 60,
            'user' => $user instanceof User ? $user->toArray() : null,
        ];
    }
}
