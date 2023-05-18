<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\SharedKernel\Exceptions\NotFoundException;

class ReadCustomerAction extends AbstractAction
{
    public function __construct(
        protected readonly CustomerQueryRepositoryContract $queryRepository
    )
    {}

    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'Success'
        );
    }
    public function controller(): array
    {
        if (filter_var($this->get('customerId'), FILTER_VALIDATE_INT) === false) {
            abort(404);
        }

        $model = $this->queryRepository->firstOrFailed($this->get('customerId'));

        return CustomerDTO::from($model->toArray())->toArray();
    }
}
