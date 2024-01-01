<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ForbiddenException extends Exception
{
    /**
     * Create a new ForbiddenException instance.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @return void
     */
    public function __construct($message = 'Maaf, akun anda tidak memiliki hak akses untuk halaman ini.', $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
