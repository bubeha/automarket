<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Class Test
 * @package App\Exceptions
 */
class AuthorizationTokenNotFound extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Authorization token not found');
    }
}
