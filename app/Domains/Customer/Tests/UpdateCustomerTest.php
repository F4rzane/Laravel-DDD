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
        $customer = Customer::factory()->create();

        $this->put(route('customers.update', ['customerId' => $customer->id]), [
            'email' => 'SOMEWRONGDATA'
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $customerData = Customer::factory()->make();

        $this->put(route('customers.update',
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
