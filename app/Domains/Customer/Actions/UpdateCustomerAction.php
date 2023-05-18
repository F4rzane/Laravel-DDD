<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use Illuminate\Validation\Rule;

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
        if (filter_var($this->get('customerId'), FILTER_VALIDATE_INT) === false) {
            abort(404);
        }
        $customer = $this->queryRepository->firstOrFailed($this->get('customerId'));
        $model = $this->commandRepository->update($this->only([
            'firstname',
            'lastname',
            'birth_date',
            'phone',
            'bank_account',
            'email',
        ]), $customer->id);

        return CustomerDTO::from($model->toArray())->toArray();
    }

    public function rules(): array
    {
        return [
            'firstname' => ['sometimes', 'required', 'string', 'min:3', 'max:250'],
            'lastname' => ['sometimes', 'required', 'string', 'min:3', 'max:250'],
            'birth_date' => ['sometimes', 'required', 'date'],
            'phone' => ['sometimes', 'required', 'string', 'max:16', 'validate_phone'],
            'bank_account' => ['sometimes', 'required', 'string', 'min:3', 'max:250'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('customers')->ignore($this->get('customerId'))]
        ];
    }
}
