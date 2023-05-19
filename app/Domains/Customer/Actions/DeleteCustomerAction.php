<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\SharedKernel\Exceptions\NotFoundException;

class DeleteCustomerAction extends AbstractAction
{
    public function __construct(
        protected readonly CustomerCommandRepositoryContract $commandRepository
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
     * @OA\DELETE(
     * path="/api/v1/customers/{customerId}",
     * summary="delete customer",
     * @OA\Parameter(
     *    description="ID of customer",
     *    in="path",
     *    name="customerId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *   )
     * ),
     *
     * @OA\Response(
     *     response=200,
     *     description="Success",
     * ))
     */
    public function controller(): void
    {
        if (filter_var($this->get('customerId'), FILTER_VALIDATE_INT) === false) {
            abort(404);
        }

        $this->commandRepository->delete($this->get('customerId'));
    }
}
