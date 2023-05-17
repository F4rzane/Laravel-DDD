<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;

class UpdateCustomerAction extends AbstractAction
{
    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'resource updated'
        );
    }
    public function controller()
    {

    }

    public function rules(): array
    {
        return [];
    }
}
