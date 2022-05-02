<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\Backend\Models\EmailTemplate;

class EmailTemplateGenerateCommand extends Command
{
    protected $signature = 'mail:generate-template';
    
    public function handle()
    {
        $basePath = 'modules/Backend/resources/data/mail_templates';
        $files = File::files(base_path($basePath));
    
        foreach ($files as $file) {
            if ($file->getExtension() != 'json') {
                continue;
            }
            
            $code = $file->getFilenameWithoutExtension();
            $data = json_decode(File::get($file->getRealPath()), true);
    
            EmailTemplate::firstOrCreate(
                [
                    'code' => $code,
                ],
                [
                    'subject' => Arr::get($data, 'subject'),
                    'body' => File::get("{$basePath}/{$code}.twig"),
                    'params' => Arr::get($data, 'params'),
                ]
            );
            
            $this->info("Created email template: {$code}");
        }
        
        return self::SUCCESS;
    }
}