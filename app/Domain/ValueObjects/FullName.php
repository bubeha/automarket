<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Embeddable */
class FullName
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $first_name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $last_name;

    /**
     * FullName constructor.
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(string $firstName, string $lastName)
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
    }
}
