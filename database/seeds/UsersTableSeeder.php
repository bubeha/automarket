<?php

declare(strict_types=1);

use App\Domain\Entities\User as UserEntity;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\FullName;
use App\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;


/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@example.com';

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * UsersTableSeeder constructor.
     * @param EntityManagerInterface $em
     * @param Hasher $hasher
     */
    public function __construct(EntityManagerInterface $em, Hasher $hasher)
    {
        $this->em = $em;
        $this->hasher = $hasher;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        if ($this->hasAdminInDatabase()) {
            return;
        }

        $email = new Email(static::ADMIN_EMAIL);
        $fullName = new FullName('admin', 'admin');
        $password = $this->hasher->make('12345678');

        $user = new UserEntity(Uuid::uuid4(), $fullName, $email, $password);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @return bool
     */
    private function hasAdminInDatabase(): bool
    {
        return (bool)User::whereEmail(self::ADMIN_EMAIL)
            ->count();
    }
}
