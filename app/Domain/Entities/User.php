<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\FullName;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;
use LaravelDoctrine\ORM\Auth\Authenticatable as AuthenticatableTrait;
use Ramsey\Uuid\UuidInterface;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Domain\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Entity implements Authenticatable, JWTSubject
{
    use AuthenticatableTrait;

    /**
     * @var FullName
     * @ORM\Embedded(class="App\Domain\ValueObjects\FullName", columnPrefix=false)
     */
    protected $fullName;

    /**
     * @var Email
     * @ORM\Embedded(class="App\Domain\ValueObjects\Email", columnPrefix=false)
     */
    private $email;

    /**
     * User constructor.
     * @param UuidInterface $id
     * @param FullName $fullName
     * @param Email $email
     * @param string $password
     */
    public function __construct(
        UuidInterface $id,
        FullName $fullName,
        Email $email,
        string $password
    ) {
        parent::__construct($id);

        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
