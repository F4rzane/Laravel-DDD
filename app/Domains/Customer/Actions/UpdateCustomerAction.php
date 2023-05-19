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
    {
    }

    /**
     * @OA\Put(
     * path="/api/v1/customers/{customerId}",
     * summary="update a new customer",
     * @OA\Parameter(
     *  description="ID of customer",
     *  in="path",
     *  name="customerId",
     *  required=true,
     *  example="1",
     *  @OA\Schema(
     *      type="integer",
     *      format="int64"
     *    )
     *),
     * @OA\RequestBody(
     *    required=false,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="firstname", type="string", example="John"),
     *       @OA\Property(property="lastname", type="string", example="Due"),
     *       @OA\Property(property="birth_date", type="string", example="2022-01-01"),
     *       @OA\Property(property="phone", type="string", example="+989121111111"),
     *       @OA\Property(property="bank_account", type="string", example="222-333212")
     * )
     *
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address. Please try again")
     *        )
     *     )
     * )
     *,
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *      @OA\JsonContent(
 *          @OA\Property(property="id", type="integer", example="1"),
 *          @OA\Property(property="firstname", type="string", example="John"),
 *          @OA\Property(property="lastname", type="string", example="Due"),
 *          @OA\Property(property="email", type="string", example="mail@gmail.com"),
 *          @OA\Property(property="birth_date", type="string", example="2015-01-01"),
 *          @OA\Property(property="phone", type="string", example="+989121111111"),
 *          @OA\Property(property="bank_account", type="string", example="222-333212")
     *  ))
     */
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

    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'resource updated'
        );
    }
}
