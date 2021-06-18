<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:53 PM
 */

namespace Mymo\Core\Providers;

use Illuminate\Support\Facades\Schema;
use Mymo\Core\Helpers\HookAction;
use Mymo\Core\Http\Middleware\Admin;
use Mymo\Core\Macros\RouterMacros;
use Mymo\Email\Providers\EmailTemplateServiceProvider;
use Mymo\FileManager\Providers\FilemanagerServiceProvider;
use Mymo\Notification\Providers\NotificationServiceProvider;
use Mymo\Performance\Providers\MymoPerformanceServiceProvider;
use Mymo\PostType\Providers\PostTypeServiceProvider;
use Mymo\Repository\Providers\RepositoryServiceProvider;
use Mymo\Theme\Providers\ThemeServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Router;
use Mymo\Updater\UpdaterServiceProvider;
use Mymo\Installer\Providers\InstallerServiceProvider;

class MymoCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootMiddlewares();
        $this->bootPublishes();
        $this->loadMigrationsFrom(core_path('database/migrations'));
        $this->loadFactoriesFrom(core_path('database/factories'));
        $this->loadViewsFrom(core_path('resources/views'), 'mymo_core');
        $this->loadTranslationsFrom(core_path('resources/lang'), 'mymo_core');

        Validator::extend('recaptcha', 'Mymo\Core\Validators\Recaptcha@validate');
        Schema::defaultStringLength(150);
    }

    public function register()
    {
        $this->registerProviders();
        $this->registerSingleton();
        $this->registerRouteMacros();
        $this->mergeConfigFrom(__DIR__ . '/../config/mymo_core.php', 'mymo_core');
    }

    protected function bootMigrations()
    {
        $mainPath = __DIR__ . '/../database/migrations';
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->publishes([
            __DIR__ . '/../config/mymo_core.php' => base_path('config/mymo_core.php'),
        ], 'mymo_config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('styles'),
        ], 'mymo_assets');
    }

    protected function registerProviders()
    {
        //$this->app->register(UpdaterServiceProvider::class);
        $this->app->register(InstallerServiceProvider::class);
        $this->app->register(DbConfigServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(MymoPerformanceServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(FilemanagerServiceProvider::class);
        //$this->app->register(TranslatableServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(PostTypeServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);
        $this->app->register(EmailTemplateServiceProvider::class);
    }

    protected function registerSingleton()
    {
        $this->app->singleton('mymo.hook', function () {
            return new HookAction();
        });
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}