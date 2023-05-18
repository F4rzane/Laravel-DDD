<?php

namespace App\Domains\Customer\Tests;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ReadCustomerTest extends TestCase
{
    protected $defaultHeaders = [
        'content-type' => 'application/x-www-form-urlencoded',
        'accept' => 'application/json',
    ];

    public function test_read_customer()
    {
        $customer = Customer::factory()->create();

        $this->get(route('customers.read',
            ['customerId' => $customer->id]))
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
                    'firstname' => $customer->firstname,
                    'lastname' => $customer->lastname,
                    'birth_date' => $customer->birth_date,
                    'phone' => $customer->phone,
                    'bank_account' => $customer->bank_account,
                    'email' => $customer->email,
                ]
            ]);

        $this->assertDatabaseHas(Customer::class, [
            'id' => $customer->id,
            'firstname' => $customer->firstname,
            'lastname' => $customer->lastname,
            'birth_date' => $customer->birth_date,
            'phone' => $customer->phone,
            'bank_account' => $customer->bank_account,
            'email' => $customer->email,
        ]);
    }

}
