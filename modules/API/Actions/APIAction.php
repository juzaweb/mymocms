<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\API\Actions;

use Juzaweb\API\Support\Documentation\PostTypeAdminSwaggerDocument;
use Juzaweb\API\Support\Documentation\PostTypeSwaggerDocument;
use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\CMS\Abstracts\Action;

class APIAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenu']);
        if (config('juzaweb.api.frontend.enable')) {
            $this->addAction(Action::API_DOCUMENT_INIT, [$this, 'addAPIDocumentation'], 1);
        }
    }
    
    public function addAPIDocumentation()
    {
        $apiAdmin = SwaggerDocument::make('frontend');
        $apiAdmin->setTitle('Frontend');
        $apiAdmin->append(PostTypeSwaggerDocument::class);
        $this->hookAction->registerAPIDocument($apiAdmin);
    }
    
    public function addAdminDocumentation()
    {
        $apiAdmin = SwaggerDocument::make('admin');
        $apiAdmin->setTitle('Admin');
        $apiAdmin->setPrefix('admin');
        $apiAdmin->append(PostTypeAdminSwaggerDocument::class);
        $this->hookAction->registerAPIDocument($apiAdmin);
    }
    
    public function addAdminMenu()
    {
        $this->hookAction->registerAdminPage(
            'api.documentation',
            [
                'title' => trans('cms::app.api_documentation'),
                'menu' => [
                    'icon' => 'fa fa-book',
                    'position' => 95,
                ],
            ]
        );
    }
}
