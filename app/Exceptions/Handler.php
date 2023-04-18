<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                Log::notice('Not Found 404: '. $e->getMessage());
                return response()->json([
                    'title' => 'Not Found',
                    'message' => 'Record not found',
                    'code' => 404
                ], 404);
            }
        });

        $this->renderable(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                Log::warning('Bad Request 400: '. $e->validator->errors());
                return response()->json([
                    'title' => 'Bad Request',
                    'message' => $e->validator->errors(),
                    'code' => 400
                ], 400);
            }
        });

        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                Log::error('Internal Server Error 500: '. $e->getMessage());
                return response()->json([
                    'title' => 'Internal Server Error',
                    'code' => 500
                ], 500);
            }
        });
    }
}
