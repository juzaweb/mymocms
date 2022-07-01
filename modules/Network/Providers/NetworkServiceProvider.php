<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Providers;

use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Network\Contracts\NetworkRegistionContract;
use Juzaweb\Network\Facades\NetworkRegistion as NetworkRegistionFacade;
use Juzaweb\Network\Support\NetworkRegistion;

class NetworkServiceProvider extends ServiceProvider
{
    public function boot()
    {
        NetworkRegistionFacade::init();
    }

    public function register()
    {
        $this->app->singleton(
            NetworkRegistionContract::class,
            function ($app) {
                return new NetworkRegistion(
                    $app,
                    $app['config'],
                    $app['request'],
                    $app['cache']
                );
            }
        );
    }
}