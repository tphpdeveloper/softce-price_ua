<?php

namespace Softce\Promua\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class PromuaServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/web.php');
        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'promua');
        $this->loadMigrationsFrom(dirname(__DIR__) . '/migrations');

        $promua = DB::table('admin_menus')->where('name', 'Prom UA')->first();
        if(is_null($promua)){
            DB::table('admin_menus')->insert([
                'admin_menu_id' => 3,
                'name' => 'Prom UA',
                'icon' => 'fa-exchange',
                'route' => 'admin.promua.index',
                'o' => 2
            ]);
        }
    }
	

    public function register(){
        //
    }

}