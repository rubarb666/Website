<?php

namespace Rhubarb\Website;

use Rhubarb\Crown\Application;
use Rhubarb\Leaf\LeafModule;
use Rhubarb\Website\Modules\WebsiteModule;

class RhubarbWebsiteApplication extends Application
{
    protected function initialise()
    {
        parent::initialise();

        include_once(__DIR__.'/../settings/site.config.php');
    }


    protected function getModules()
    {
        return [
            new WebsiteModule(),
            new LeafModule()
        ];
    }
}