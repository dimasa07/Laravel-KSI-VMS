<?php

namespace App\Providers;

use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\TamuService;
use Illuminate\Support\ServiceProvider;

class DependencyInjectionProvider extends ServiceProvider
{
    public array $singletons = [
        AkunService::class,
        TamuService::class,
        PegawaiService::class,
        PermintaanBertamuService::class,
        BukuTamuService::class 
    ]; 

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
