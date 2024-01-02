<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use App\Exceptions\ForbiddenException; // Tambahkan use statement
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = ['current_password', 'password', 'password_confirmation'];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // view untuk user doesnt have roles/permission
        if ($e instanceof UnauthorizedException || $e instanceof ForbiddenException) {
            return response()->view('errors.403', ['exception' => $e->getMessage()], 403);
        }
        // view untuk 404 error
        elseif ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404');
        }
        // view untuk 419 error (Page Expired)
        elseif ($this->isHttpException($e) && $e->getStatusCode() == 419) {
            return response()->view('errors.419', [], 419);
        }
        // view untuk 500 error
        elseif ($this->isHttpException($e)) {
            return $this->renderHttpException($e);
        }
        // view untuk \ErrorException
        elseif ($e instanceof \ErrorException) {
            return response()->view('errors.500', [], 500);
        }

        return parent::render($request, $e);
    }
}
