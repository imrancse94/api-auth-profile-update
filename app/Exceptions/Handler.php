<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Routing\Router;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

    // public function render($request, Throwable $e){

    //     $error = "Something wrong";
    //     //dd($e->getMessage(),$e);
    //     $code = 500;
    //     if($e instanceof AuthorizationException){
    //         $error = "Unauthenticated";
    //         $code = 401;
    //         return $this->sendError($error,[],$code);
    //     }

    //     if (method_exists($e, 'render') && $response = $e->render($request)) {
    //         return Router::toResponse($request, $response);
    //     } elseif ($e instanceof Responsable) {
    //         return $e->toResponse($request);
    //     }

    //     $e = $this->prepareException($this->mapException($e));

    //     foreach ($this->renderCallbacks as $renderCallback) {
    //         foreach ($this->firstClosureParameterTypes($renderCallback) as $type) {
    //             if (is_a($e, $type)) {
    //                 $response = $renderCallback($e, $request);

    //                 if (! is_null($response)) {
    //                     return $response;
    //                 }
    //             }
    //         }
    //     }

    //     if ($e instanceof HttpResponseException) {
    //         return $e->getResponse();
    //     } elseif ($e instanceof AuthenticationException) {
    //         return $this->unauthenticated($request, $e);
    //     } elseif ($e instanceof ValidationException) {
    //         return $this->convertValidationExceptionToResponse($e, $request);
    //     }

    //     return $this->shouldReturnJson($request, $e)
    //                 ? $this->prepareJsonResponse($request, $e)
    //                 : $this->prepareResponse($request, $e);
    // }
}
