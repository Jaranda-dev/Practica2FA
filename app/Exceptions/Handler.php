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
        return response()->view('errors.custom', [
            'message' => 'Página no encontrada',
            'code' => 404,
            'redirect' => url('/')
        ], 404);
    }

    // 2. Error 403 - Acceso denegado
    if ($exception instanceof AccessDeniedHttpException) {
        return response()->view('errors.custom', [
            'message' => 'No tienes permiso para acceder a esta página',
            'code' => 403,
            'redirect' => url('/')
        ], 403);
    }

    // 3. Error 401 - No autenticado
    if ($exception instanceof AuthenticationException) {
        return response()->view('errors.custom', [
            'message' => 'Debes iniciar sesión para acceder a esta página',
            'code' => 401,
            'redirect' => url('/login')
        ], 401);
    }

    // 4. Error 419 - Expiración de sesión
    if ($exception->getCode() === 419) {
        return response()->view('errors.custom', [
            'message' => 'Tu sesión ha expirado, por favor inicia sesión nuevamente',
            'code' => 419,
            'redirect' => url('/login')
        ], 419);
    }

    // 5. Error 405 - Método no permitido
    if ($exception instanceof MethodNotAllowedHttpException) {
        return response()->view('errors.custom', [
            'message' => 'Método no permitido para esta ruta',
            'code' => 405,
            'redirect' => url('/')
        ], 405);
    }

    // 6. Error 429 - Demasiadas solicitudes
    if ($exception instanceof ThrottleRequestsException) {
        return response()->view('errors.custom', [
            'message' => 'Has realizado demasiadas solicitudes. Intenta nuevamente más tarde.',
            'code' => 429,
            'redirect' => url('/')
        ], 429);
    }

    // 7. Error 422 - Fallo en validación de datos
    if ($exception instanceof ValidationException) {
        return response()->json([
            'message' => 'Los datos proporcionados no son válidos.',
            'errors' => $exception->errors()
        ], 422);
    }

    // 8. Error 500 - Errores de Base de Datos
    if ($exception instanceof QueryException) {
        return response()->view('errors.custom', [
            'message' => 'Error en la consulta a la base de datos',
            'code' => 500,
            'redirect' => url('/')
        ], 500);
    }

    if ($exception instanceof ModelNotFoundException) {
        return response()->view('errors.custom', [
            'message' => 'El recurso solicitado no se encontró',
            'code' => 404,
            'redirect' => url('/')
        ], 404);
    }

    if ($exception instanceof ConnectionException) {
        return response()->view('errors.custom', [
            'message' => 'No se pudo conectar a la base de datos',
            'code' => 500,
            'redirect' => url('/')
        ], 500);
    }

    if ($exception instanceof PDOException) {
        return response()->view('errors.custom', [
            'message' => 'Error en la conexión con la base de datos',
            'code' => 500,
            'redirect' => url('/')
        ], 500);
    }

    // 9. Manejo general de errores 500
    return response()->view('errors.custom', [
        'message' => $exception->getMessage() ?: 'Ha ocurrido un error inesperado',
        'code' => 500,
        'redirect' => url('/')
    ], 500);
}




}
