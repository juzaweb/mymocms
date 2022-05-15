<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public function getNamespace()
    {
        return 'Juzaweb/CMS';
    }
}
