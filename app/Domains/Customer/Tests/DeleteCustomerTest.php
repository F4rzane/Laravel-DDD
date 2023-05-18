<?php

namespace App\Domains\Customer\Tests;

use App\Models\Customer;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{
    protected $defaultHeaders = [
        'content-type' => 'application/x-www-form-urlencoded',
        'accept' => 'application/json',
    ];

    public function test_read_customer()
    {
        $customer = Customer::factory()->create();

        $this->delete(route('customers.delete',
            ['customerId' => $customer->id]))
            ->assertStatus(Response::HTTP_OK);

        $this->assertSoftDeleted(Customer::class, [
            'id' => $customer->id,
        ]);
    }

}
