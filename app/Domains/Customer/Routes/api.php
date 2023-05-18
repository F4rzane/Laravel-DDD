<?php

use App\Domains\Customer\Actions\CreateCustomerAction;
use App\Domains\Customer\Actions\UpdateCustomerAction;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v3',
], function () {
    Route::post('/customers', CreateCustomerAction::class)->name('customers.create');
    Route::post('/customers/{customerId}', UpdateCustomerAction::class)->name('customers.update');
});
