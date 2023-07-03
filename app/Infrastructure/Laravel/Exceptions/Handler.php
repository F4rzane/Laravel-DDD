<?php

namespace App\Infrastructure\Laravel\Exceptions;

use App\Application\Enums\ResponseTypeEnum;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\DTOs\Responses\MetaDTO;
use App\Common\DTOs\Responses\ResponseDTO;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */

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
        return  parent::render($request, $e);
        $response = parent::render($request, $e);
        $errors = [];
        $message = $e->getMessage();

        if (is_a($e, ValidationException::class)) {
            $message = 'validation';
            $errors = $e->validator->getMessageBag()->toArray();
        }

        return ResponseDTO::from([
            'ok' => false,
            'meta' => MetaDTO::from([
                'message' => MessageDTO::from([
                    'body' => $message,
                    'type' => ResponseTypeEnum::ERROR->value,
                ]),
            ]),
            'errors' => $errors,
        ])
            ->toResponse($request)
            ->setStatusCode($response->getStatusCode())
            ->withHeaders($response->headers->all());
    }
}
