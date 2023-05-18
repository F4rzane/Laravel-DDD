<?php

namespace App\Domains\Customer\Tests;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateCustomerTest extends TestCase
{
    protected $defaultHeaders = [
        'content-type' => 'application/x-www-form-urlencoded',
        'accept' => 'application/json',
    ];

    public function test_update_customer()
    {
        $this->post(route('customers.create'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $customer = Customer::factory()->create();

        $customerData = Customer::factory()->make();

        $this->post(route('customers.update',
            ['customerId' => $customer->id]), $customerData->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'result' => [
                    'firstname',
                    'lastname',
                    'birth_date',
                    'phone',
                    'bank_account',
                    'email',
                ]
            ])
            ->assertJson([
                'result' => [
                    'id' => $customer->id,
                    'firstname' => $customerData->firstname,
                    'lastname' => $customerData->lastname,
                    'birth_date' => $customerData->birth_date,
                    'phone' => $customerData->phone,
                    'bank_account' => $customerData->bank_account,
                    'email' => $customerData->email,
                ]
            ]);

        $this->assertDatabaseHas(Customer::class, [
            'id' => $customer->id,
            'firstname' => $customerData->firstname,
            'lastname' => $customerData->lastname,
            'birth_date' => $customerData->birth_date,
            'phone' => $customerData->phone,
            'bank_account' => $customerData->bank_account,
            'email' => $customerData->email,
        ]);
    }

}