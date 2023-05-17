<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;

class CreateCustomerAction extends AbstractAction
{
    public function __construct(
        protected readonly CustomerCommandRepositoryContract $commandRepository
    )
    {}

    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'resource created'
        );
    }
    public function controller()
    {
        $model = $this->commandRepository->create($this->only([
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
        return [
            'firstname' => ['required', 'string', 'min:3', 'max:250'],
            'lastname' => ['required', 'string', 'min:3', 'max:250'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:16'],
            'bank_account' => ['required', 'string', 'min:3', 'max:250'],
            'email' => ['required', 'email', 'unique:customers'],
        ];
    }
}
