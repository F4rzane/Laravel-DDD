<?php

namespace App\Infrastructure\Domains\Actions;

use App\Common\DTOs\Responses\MessageDTO;
use App\Common\DTOs\Responses\MetaDTO;
use App\Common\DTOs\Responses\ResponseDTO;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;
use Symfony\Component\HttpFoundation\Response;

Abstract class AbstractAction
{
    use AsAction,
        WithAttributes;


    /**
     * @OA\Info(
     *    title="Customer CRUD",
     *    version="1.0.0",
     * )
     * @OA\Server(
     *      url= "http://127.0.0.1:8089",
     *      description="Localhost"
     *  )
     */
    final public function asController(ActionRequest $request, ...$args): Response
    {
        $this->fillFromRequest($request);

        $this->validateAttributes();

        $result  = match (true){
            method_exists($this, 'cachedResponse') => $this->cachedResponse(),
            default => $this->controller(),
        };

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
