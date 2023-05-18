<?php

namespace App\Domains\Customer;

use App\Domains\Customer\Contracts\CustomerCommandRepositoryContract;
use App\Domains\Customer\Contracts\CustomerQueryRepositoryContract;
use App\Domains\Customer\Repositories\CustomerCommandRepository;
use App\Domains\Customer\Repositories\CustomerQueryRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
{
    protected array $rules = [
        'validate_phone' => Rules\ValidatePhone::class,
    ];

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
        foreach ($this->rules as $rule => $ruleClass) {
            Validator::extend(
                $rule,
                function ($attribute, $value) use ($ruleClass) {
                    return app()->make($ruleClass)->passes($attribute, $value);
                },
                app()->make($ruleClass)->message()
            );
        }

        Route::prefix('api')
            ->middleware('api')
            ->group(app_path('Domains/Customer/routes/api.php'));
    }
}
