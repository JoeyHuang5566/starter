<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\MyException;
use App\Traits\JsonRender;

class Handler extends ExceptionHandler
{
    use JsonRender;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        MyException::class
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (MyException $e, $request) {
            return $this->jsonRenderResultWithError(
                $e->getMessage(),
                $e->getStatusCode(),
                $e->getOption()
            );
        });
    }
}
