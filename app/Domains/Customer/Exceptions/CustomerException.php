<?php

namespace App\Domains\Customer\Exceptions;

use App\Common\DTOs\Responses\MessageDTO;
use App\Common\DTOs\Responses\MetaDTO;
use App\Common\DTOs\Responses\ResponseDTO;
use App\Common\Enums\ResponseTypeEnum;
use Exception;
use Throwable;

class CustomerException extends Exception
{
    public function render()
    {
        $responseDTO =  ResponseDTO::from([
            'ok' => false,
            'meta' => MetaDTO::from([
                'message' => MessageDTO::from([
                    'type' => ResponseTypeEnum::ERROR->value,
                    'body' => $this->getMessage(),
                ]),
            ]),
        ]);

        return response()->json($responseDTO->toArray())->setStatusCode(400);
    }
}
