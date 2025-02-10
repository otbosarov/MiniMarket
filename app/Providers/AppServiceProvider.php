<?php

namespace App\Providers;

use App\Interfaces\BenefitInterface;
use App\Interfaces\CategoriyaInterface;
use App\Interfaces\CurrencyInterface;
use App\Interfaces\InputProductInterface;
use App\Interfaces\ProductDetailInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\UserInterface;
use App\Repositories\BenefitRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\InputProductRepository;
use App\Repositories\ProductDetailRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(CategoriyaInterface::class, CategoryRepository::class);
        $this->app->singleton(CurrencyInterface::class, CurrencyRepository::class);
        $this->app->singleton(ProductDetailInterface::class, ProductDetailRepository::class);
        $this->app->singleton(BenefitInterface::class, BenefitRepository::class);
        $this->app->singleton(ProductInterface::class, ProductRepository::class);
        $this->app->singleton(InputProductInterface::class,InputProductRepository::class);

    }
}
