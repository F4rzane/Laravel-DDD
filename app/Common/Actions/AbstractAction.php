<?php

namespace App\Common\Actions;

use App\Common\DTOs\Responses\MessageDTO;
use App\Common\DTOs\Responses\MetaDTO;
use App\Common\DTOs\Responses\ResponseDTO;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response;

Abstract class AbstractAction
{
    use AsAction;

    final public function asController(ActionRequest $request, ...$args): Response
    {
        $result = call_user_func('static::controller', ...$args);

        $responseDTO = ResponseDTO::from([
            'meta' => MetaDTO::from([
                'message' => $this->responseMessage(),
            ]),
        ]);

        if (is_array($result)) {
            $responseDTO->result = $result;
        }

        return $responseDTO->toResponse($request)->setStatusCode($this->responseHttpStatusCode());
    }

    protected function responseMessage(): ?MessageDTO
    {
        return null;
    }

    protected function responseHttpStatusCode(): int
    {
        return Response::HTTP_OK;
    }

}
