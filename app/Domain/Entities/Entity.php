<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Support\Arrayable;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Entity
 * @package App\Domain\Entities
 */
abstract class Entity implements Arrayable
{
    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

    /**
     * Entity constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id->toString();
    }
}
