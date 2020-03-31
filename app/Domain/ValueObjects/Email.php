<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class Email
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Email {$email} is not valid");
        }

        $this->email = $email;
    }
}
