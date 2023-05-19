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
    /**
     * @OA\Get(
     * path="/api/v1/customers/{customerId}",
     * summary="read a customer",
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
     *  )))
     */
    public function controller(): array
    {
        if (filter_var($this->get('customerId'), FILTER_VALIDATE_INT) === false) {
            abort(404);
        }

        $model = $this->queryRepository->firstOrFailed($this->get('customerId'));

        return CustomerDTO::from($model->toArray())->toArray();
    }
}
