<?php

use App\Domains\Customer\Actions\CreateCustomerAction;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v3',
], function () {
    Route::post('/customers', CreateCustomerAction::class)->name('customers.create');
});
