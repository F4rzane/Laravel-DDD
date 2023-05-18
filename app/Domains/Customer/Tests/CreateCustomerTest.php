<?php

namespace App\Domains\Customer\Tests;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    protected $defaultHeaders = [
        'content-type' => 'application/x-www-form-urlencoded',
        'accept' => 'application/json',
    ];

    public function test_create_customer()
    {
        $this->post(route('customers.create'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $wrongNumberCustomer = Customer::factory()->make([
            'phone' => fake()->numerify('####')
        ]);

        $this->post(route('customers.create'), $wrongNumberCustomer->toArray())
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $customer = Customer::factory()->make();

        $customerCreated = $this->post(route('customers.create'), $customer->toArray())
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
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'birth_date' => $customer->birth_date,
                    'phone' => $customer->phone,
                    'bank_account' => $customer->bank_account,
                    'email' => $customer->email,
                ]
            ]);

        $this->assertDatabaseHas(Customer::class, [
            'id' => $customerCreated['result']['id'],
            'firstname' => $customer->firstname,
            'lastname' => $customer->lastname,
            'birth_date' => $customer->birth_date,
            'phone' => $customer->phone,
            'bank_account' => $customer->bank_account,
            'email' => $customer->email,
        ]);
    }

}
