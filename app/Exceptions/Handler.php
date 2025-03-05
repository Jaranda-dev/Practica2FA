<?php

namespace App\Exceptions;





use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

   /**
     * Renderiza una respuesta para la excepción.
     */
    public function render($request, Throwable $exception)
    {
        // 1. Error 404 - Página no encontrada
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [
                'message' => 'Página no encontrada',
                'code' => 404
            ], 404);
        }

        // 2. Error 403 - Acceso denegado
        if ($exception instanceof AccessDeniedHttpException) {
            return response()->view('errors.403', [
                'message' => 'No tienes permiso para acceder a esta página',
                'code' => 403
            ], 403);
        }

        // 3. Error 401 - No autenticado
        if ($exception instanceof AuthenticationException) {
            return redirect()->route('login');
        }

        // 4. Error 419 - Expiración de sesión
        if ($exception->getCode() === 419) {
            return response()->view('errors.419', [
                'message' => 'Tu sesión ha expirado, por favor inicia sesión nuevamente',
                'code' => 419
            ], 419);
        }

        // 5. Error 422 - Errores de validación
        if ($exception instanceof ValidationException) {
            return response()->view('errors.422', [
                'message' => 'Hay errores en la validación de los datos',
                'code' => 422,
                'errors' => $exception->errors() // Muestra los errores de validación
            ], 422);
        }

        // 6. Error 500 - Error interno del servidor (General)
        return response()->view('errors.custom', [
            'message' => $exception->getMessage() ?: 'Ha ocurrido un error inesperado',
            'code' => $exception->getCode() ?: 500
        ], 500);
    }


}
