<?php

namespace Juzaweb\CMS\Support\Updater;

use Illuminate\Support\Facades\Artisan;
use Juzaweb\CMS\Abstracts\Plugin;
use Juzaweb\CMS\Support\Manager\UpdateManager;
use Juzaweb\CMS\Version;

class CmsUpdater extends UpdateManager
{
    protected array $updatePaths = [
        'modules',
        'vendor',
        'composer.json'
    ];

    public function getCurrentVersion(): string
    {
        return get_version_by_tag(Version::getVersion());
    }

    public function getVersionAvailable(): string
    {
        $uri = 'cms/version-available';
        $data = [
            'current_version' => $this->getCurrentVersion(),
        ];

        $response = $this->api->get($uri, $data);

        return get_version_by_tag($response->version);
    }

    public function fetchData(): void
    {
        $uri = 'cms/update';

        $response = $this->api->get(
            $uri,
            [
                'current_version' => $this->getCurrentVersion(),
            ]
        );

        $this->response = $response;
    }

    public function afterFinish()
    {
        Artisan::call('migrate', ['--force' => true]);

        Artisan::call(
            'vendor:publish',
            [
                '--tag' => 'cms_assets',
                '--force' => true,
            ]
        );

        /**
         * @var Plugin[] $plugins
         */
        $plugins = app('plugins')->all();
        foreach ($plugins as $plugin) {
            if (!$plugin->isEnabled()) {
                continue;
            }

            $plugin->disable();
            $plugin->enable();
        }

        $theme = jw_current_theme();
        Artisan::call(
            'theme:publish',
            [
                'theme' => $theme,
                'type' => 'assets',
            ]
        );
    }

    protected function getLocalPath(): string
    {
        return base_path();
    }
}
