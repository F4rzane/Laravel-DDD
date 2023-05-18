<?php

use App\Domains\Customer\Actions\CreateCustomerAction;
use App\Domains\Customer\Actions\DeleteCustomerAction;
use App\Domains\Customer\Actions\ReadCustomerAction;
use App\Domains\Customer\Actions\UpdateCustomerAction;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v3',
], function () {
    Route::post('/customers', CreateCustomerAction::class)->name('customers.create');
    Route::post('/customers/{customerId}', UpdateCustomerAction::class)->name('customers.update');
    Route::get('/customers/{customerId}', ReadCustomerAction::class)->name('customers.read');
    Route::delete('/customers/{customerId}', DeleteCustomerAction::class)->name('customers.delete');
});
