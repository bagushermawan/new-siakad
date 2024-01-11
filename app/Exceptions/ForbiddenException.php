<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ForbiddenException extends Exception
{
    public function __construct($message = '', $code = 403, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Maaf, Anda tidak memiliki hak akses untuk halaman ini.';
        }

        parent::__construct($message, $code, $previous);
    }
}
