<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('ggg', function ($value) {
            $class = "red__shade-3 caption-light";
            return  '<?php echo "<span class="$class">'."$value".'</span>" ?>';
        });
    }
}
