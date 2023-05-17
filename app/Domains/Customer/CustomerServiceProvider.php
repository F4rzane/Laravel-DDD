<?php

namespace App\Domains\Customer;

use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\Domains\Customer\Repositories\CustomerCommandRepository;
use App\Domains\Customer\Repositories\CustomerQueryRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomerCommandRepositoryContract::class, CustomerCommandRepository::class);
        $this->app->bind(CustomerQueryRepositoryContract::class, CustomerQueryRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(app_path('Domains/Customer/routes/api.php'));
    }
}
