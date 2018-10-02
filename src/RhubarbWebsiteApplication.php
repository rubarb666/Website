<?php

namespace Rhubarb\Website;

use Rhubarb\Crown\Application;
use Rhubarb\Leaf\LayoutProviders\LayoutProvider;
use Rhubarb\Leaf\LeafModule;
use Rhubarb\Website\Layouts\FieldSetWithLabelsLayoutProvider;
use Rhubarb\Website\Modules\WebsiteModule;

class RhubarbWebsiteApplication extends Application
{
    protected function initialise()
    {
        parent::initialise();

        if (file_exists(__DIR__.'/../settings/site.config.php')) {
            include_once(__DIR__ . '/../settings/site.config.php');
        }

        LayoutProvider::setProviderClassName(FieldSetWithLabelsLayoutProvider::class);
    }


    protected function getModules()
    {
        return [
            new WebsiteModule(),
            new LeafModule()
        ];
    }
}