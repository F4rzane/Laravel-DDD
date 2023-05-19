<?php

namespace App\Domains\Customer\Actions;

use App\Common\Actions\AbstractAction;
use App\Common\DTOs\Customer\CustomerDTO;
use App\Common\DTOs\Responses\MessageDTO;
use App\Common\Enums\ResponseTypeEnum;
use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\Domains\Customer\Exceptions\CustomerException;
use Symfony\Component\HttpFoundation\Response;
use function Termwind\render;

class CreateCustomerAction extends AbstractAction
{
    public function __construct(
        protected readonly CustomerCommandRepositoryContract $commandRepository,
        protected readonly CustomerQueryRepositoryContract $queryRepository,
    )
    {}

    protected function responseMessage(): ?MessageDTO
    {
        return new MessageDTO(
            type: ResponseTypeEnum::SUCCESS->value,
            body: 'resource created'
        );
    }

    /**
     * @OA\Post(
     * path="/api/v1/customers",
     * summary="creat a new customer",
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"firstname","lastname", "birth_date", "phone", "bank_account", "email"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="firstname", type="string", example="John"),
     *       @OA\Property(property="lastname", type="string", example="Due"),
     *       @OA\Property(property="birth_date", type="string", example="2022-01-01"),
     *       @OA\Property(property="phone", type="string", example="+989121111111"),
     *       @OA\Property(property="bank_account", type="string", example="222-333212")
     *    ),
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
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example="1"),
     * @OA\Property(property="firstname", type="string", example="John"),
     * @OA\Property(property="lastname", type="string", example="Due"),
     * @OA\Property(property="email", type="string", example="mail@gmail.com"),
     * @OA\Property(property="birth_date", type="string", example="2015-01-01"),
     * @OA\Property(property="phone", type="string", example="+989121111111"),
     * @OA\Property(property="bank_account", type="string", example="222-333212")
     *  ))
     * @throws CustomerException
     */
    public function controller(): array
    {
        $checkDuplicateCustomer = $this->queryRepository->findWhere([
            'firstname' => $this->get('firstname'),
            'lastname' => $this->get('lastname'),
            'birth_date' => $this->get('birth_date')
        ]);

        if($checkDuplicateCustomer->isNotEmpty()){
            throw new CustomerException('another customer with same credentials already exists');
        }

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

    protected function responseHttpStatusCode(): int
    {
        return Response::HTTP_CREATED;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'min:3', 'max:250'],
            'lastname' => ['required', 'string', 'min:3', 'max:250'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:16', 'validate_phone'],
            'bank_account' => ['required', 'string', 'min:3', 'max:250'],
            'email' => ['required', 'email', 'unique:customers'],
        ];
    }
}
