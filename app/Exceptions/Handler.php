<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
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
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof ModelNotFoundException){

            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Specified identifier for {$modelName} doesn't exists", 404);
        }

        if($exception instanceof AuthenticationException){
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse("The specified URL is not valid", 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse("The specified method for the request is not valid", 405);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            
            $errorCode = $exception->errorInfo[1];

            if($errorCode == 1451){
                return $this->errorResponse('Cannot remove this resource, It is related with another resource.', 409);
            }

            if($errorCode == 1048){
                return $this->errorResponse('Contraint violation. Null value was inserted into required column', 406);
            }
        }

        // comment out this line if a more specific error message is needed
        // return $this->errorResponse('Unexpected Exception, Try Later', 500);

        // If the application is in debug mode, show error responses in detail
        if(config('app.debug')){
            return parent::render($request, $exception);
        }
    }



    /**
     * Create a response object from the given validation exception.
     *
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
            return $this->errorResponse('Unauthenticated', 401);
    }



    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        $errors = $e->validator->errors()->getMessages();
        return $this->errorResponse($errors, 422);
    }
}
