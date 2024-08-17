<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    // public function render($request, Throwable $exception)
    // {
    //     if ($this->isHttpException($exception)) {
    //         return $this->renderHttpException($exception);
    //     } else {
    //         if (config('app.debug') == false) {
    //             return redirect()->route('custom.error'); // Redirige a la ruta definida en las rutas
    //         }
    //         return parent::render($request, $exception);
    //     }
    // }

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof HttpException) {
    //         return $this->renderHttpException($exception);
    //     } else {
    //         if (config('app.debug') == false) {
    //             return redirect()->route('custom.error'); // Redirige a la ruta definida en las rutas
    //         }
    //         return parent::render($request, $exception);
    //     }
    // }

    // public function render($request, Throwable $exception)
    // {
    //     if ($this->isHttpException($exception)) {
    //         return $this->renderHttpException($exception);
    //     } elseif ($exception instanceof ValidationException) {
    //         // Si es una excepción de validación, manejarla según sea necesario
    //         return parent::render($request, $exception);
    //     } else {
    //         if (config('app.debug') == false) {
    //             return redirect()->route('custom.error'); // Redirige a la ruta definida en las rutas
    //         }
    //         return parent::render($request, $exception);
    //     }
    // }
        
    


}
