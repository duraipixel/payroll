<?php

namespace App\Providers;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\AttendanceRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $academic = AcademicYear::where('status', 'active')->orderBy('from_year', 'desc')->get();
        View::share('global_academic_year',$academic);
        
    }
}
