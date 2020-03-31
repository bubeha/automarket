<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\FullName;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class User
 * @package App\Domain\Entities
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Entity
{
    /**
     * @var FullName
     * @ORM\Embedded(class="App\domain\ValueObjects\FullName", columnPrefix=false)
     */
    protected FullName $fullName;

    /**
     * @var Email
     * @ORM\Embedded(class="App\Domain\ValueObjects\Email", columnPrefix=false)
     */
    private Email $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

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
}
