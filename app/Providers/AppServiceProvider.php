<?php

namespace App\Providers;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use App\Models\{Programme, User};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        //envoie mail au promoteur si cahier des change n'est pas payer

        // $programme = Programme::create([
        //     'jour' => "TETET",
        //     'heure_debut' => "TETET",
        //     'heure_fin' => "TETET",
        //     'uuid' => (string) Str::uuid()
        // ]);

        // $admin = User::whereIn("id_role", function ($query){
        //     $query->from("role")->whereNom("Admin")->select("id_role")->get();
        // })->first();

        // dd($admin);

        //dd($programme);
    }
}
