<?php

namespace App\Exceptions;

// use Exception;
use App\Helpers\LogActivity;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ControllerDoesNotReturnResponseException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use ErrorException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use BadMethodCallException;
use GuzzleHttp\Exception\TooManyRedirectsException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Throwable $exception)
    {
        if (
            $exception instanceof MethodNotAllowedHttpException
            || $exception instanceof ControllerDoesNotReturnResponseException
            || $exception instanceof BadRequestHttpException
            || $exception instanceof TooManyRequestsHttpException
            || $exception instanceof UrlGenerationException
            || $exception instanceof PostTooLargeException
            || $exception instanceof ErrorException
            || $exception instanceof BadMethodCallException
            || $exception instanceof TooManyRedirectsException
        ) {
            $kalimat = 'Error: ' . $exception->getMessage();

            return redirect('/dashboard')
                ->with([
                    'error' => $kalimat
                ]);
        }
        if ($exception instanceof NotFoundHttpException) {
            if ($request->is('api/*')) {
                $kalimat = 'Error: ' . $exception->getMessage();

                return response()->json([
                    'error' => true,
                    'message' => 'Not Found'
                ], 404);
            }
            $kalimat = 'Error: ' . $exception->getMessage();
            return redirect('/dashboard')
                ->with([
                    'error' => $kalimat
                ]);
        }
        if ($exception instanceof UnauthorizedException) {
            $kalimat = 'Forbidden & ' . $exception->getMessage();

            if ($request->is('api/*')) {
                return response()->json([
                    'error' => true,
                    'message' => $kalimat
                ], 403);
            }
        }
        return parent::render($request, $exception);
    }
}
