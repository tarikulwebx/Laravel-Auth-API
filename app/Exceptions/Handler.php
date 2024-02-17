<?php

namespace App\Exceptions;

use App\Http\Helpers\Helper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

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

        $this->renderable(function (Throwable $e, $request) {

            // Default Middleware Exception (Spatie\Permission)
            if ($e instanceof AccessDeniedHttpException) {
                return Helper::errorResponse("You do not have the required authorization.", [], 403);
            }

            // Authentication Exception (Sanctum)
            if ($e instanceof AuthenticationException && $request->expectsJson()) {
                return
                    Helper::errorResponse("You are unauthenticated!", [], 401);
            }

            // Package Middleware Exception (Spatie\Permission)
            if ($e instanceof UnauthorizedException) {
                return Helper::errorResponse("You do not have the right roles.", [], 403);
            }

            // RouteNotFoundException
            if ($e instanceof RouteNotFoundException) {
                return
                    Helper::errorResponse("Route not properly made!", [], 401);
            }
        });
    }
}
