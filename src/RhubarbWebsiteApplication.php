<?php

namespace Rhubarb\Website;

use Rhubarb\Crown\Application;
use Rhubarb\Stem\Repositories\MySql\MySql;
use Rhubarb\Stem\Repositories\Repository;
use Rhubarb\Stem\Schema\SolutionSchema;
use Rhubarb\Website\Models\CommentSolutionSchema;
use Rhubarb\Website\Models\DemoSolutionSchema;
use Rhubarb\Website\Modules\WebsiteModule;

class RhubarbWebsiteApplication extends Application
{
    protected function initialise()
    {

        if (file_exists(APPLICATION_ROOT_DIR . "/settings/site.config.php")) {
            include_once(APPLICATION_ROOT_DIR . "/settings/site.config.php");
        }

        parent::initialise();
        Repository::setDefaultRepositoryClassName(MySql::class);
        SolutionSchema::registerSchema("Website", DemoSolutionSchema::class);
    }

    protected function getModules()
    {
        return [
            new WebsiteModule()
        ];
    }
}