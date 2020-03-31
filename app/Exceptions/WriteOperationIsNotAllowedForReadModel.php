<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Class WriteOperationIsNotAllowedForReadModel
 * @package App\Exceptions
 */
class WriteOperationIsNotAllowedForReadModel extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Write operation is not allowed for read model');
    }
}
