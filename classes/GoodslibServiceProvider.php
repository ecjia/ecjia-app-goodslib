<?php

namespace Ecjia\App\Goodslib;

use Royalcms\Component\App\AppParentServiceProvider;

class GoodslibServiceProvider extends  AppParentServiceProvider
{
    
    public function boot()
    {
        $this->package('ecjia/app-goodslib', null, dirname(__DIR__));
    }
    
    public function register()
    {
        
    }
    
    
    
}