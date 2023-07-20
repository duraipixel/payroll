<?php

namespace App\Providers;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Blade;
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
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('isCheck', function ($expression) {
            // Custom logic for your directive
            return "<?php if (isset($expression) && !empty($expression)) { ?>";
        });
        
        Blade::directive('el', function () {
            return '<?php } else { ?>';
        });
        
        Blade::directive('endIsCheck', function () {
            return '<?php } ?>';
        });     

    }
}
