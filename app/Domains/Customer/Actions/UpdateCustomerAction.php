<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;

class UpdateCustomerAction extends AbstractAction
{
    public function __construct(
        protected readonly CustomerCommandRepositoryContract $commandRepository,
        protected readonly CustomerQueryRepositoryContract $queryRepository
    )
    {}

    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'resource updated'
        );
    }
    public function controller()
    {
        $customer = $this->queryRepository->firstOrFailed($this->get('customerId'));

        $model = $this->commandRepository->update($this->only([
            'firstname',
            'lastname',
            'birth_date',
            'phone',
            'bank_account',
            'email',
        ]));

        return CustomerDTO::from($model->toArray())->toArray();
    }

    public function rules(): array
    {
        return [];
    }
}
