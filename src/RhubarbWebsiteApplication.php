<?php

namespace Rhubarb\Website;

use Rhubarb\Crown\Application;
use Rhubarb\Leaf\LeafModule;
use Rhubarb\Website\Modules\WebsiteModule;

class RhubarbWebsiteApplication extends Application
{
    protected function getModules()
    {
        return [
            new WebsiteModule(),
            new LeafModule()
        ];
    }
}