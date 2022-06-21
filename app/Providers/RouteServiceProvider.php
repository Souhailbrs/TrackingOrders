<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapSellerRoutes();
        $this->mapDeliveryRoutes();
        $this->mapSupporterRoutes();
        $this->mapPackagingRoutes();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Site')
            ->group(base_path('routes/web.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware(['web','isAdmin','isSuperAdmin'])
            ->namespace($this->namespace . '\Admin')
            ->group(base_path('routes/admin.php'));
    }
    protected function mapSellerRoutes()
    {
        Route::middleware(['web','isSeller'])
            ->namespace($this->namespace . '\Seller')
            ->name('seller.')
            ->group(base_path('routes/seller.php'));
    }
    protected function mapDeliveryRoutes()
    {
        Route::middleware(['web','isDelivery'])
            ->namespace($this->namespace . '\Delivery')
            ->name('delivery.')
            ->group(base_path('routes/delivery.php'));
    }
    protected function mapSupporterRoutes()
    {
        Route::middleware(['web','isSupporter'])
            ->namespace($this->namespace . '\Supporter')
            ->name('supporter.')
            ->group(base_path('routes/supporter.php'));
    }
    protected function mapPackagingRoutes(){
        Route::middleware(['web','isPackaging'])
            ->namespace($this->namespace . '\Packaging')
            ->name('packaging.')
            ->group(base_path('routes/packaging.php'));
    }
/*$this->mapSellerRoutes();
$this->mapDeliveryRoutes();
$this->mapSupporterRoutes();*/
    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
