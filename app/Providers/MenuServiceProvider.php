<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
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
            $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
            $verticalMenuData = json_decode($verticalMenuJson);
            $kategoriCoaJson = file_get_contents(base_path('resources/menu/kategoriCoa.json'));
            $kategoriCoaData = json_decode($kategoriCoaJson);

            // Share all menuData to all the views
            View::share('menuData', [$verticalMenuData, $kategoriCoaData]);
      }
}
