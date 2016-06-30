<?php

namespace Rhubarb\Website\Modules;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\ClassMappedUrlHandler;
use Rhubarb\RestApi\Resources\ApiDescriptionResource;
use Rhubarb\RestApi\Resources\ModelRestResource;
use Rhubarb\RestApi\UrlHandlers\RestApiRootHandler;
use Rhubarb\RestApi\UrlHandlers\RestCollectionHandler;
use Rhubarb\Stem\Schema\SolutionSchema;
use Rhubarb\Website\Layouts\DefaultLayout;
use Rhubarb\Website\Models\Contact;
use Rhubarb\Website\Models\Organisation;
use Rhubarb\Website\RestResources\OrganisationResource;
use Rhubarb\Website\UrlHandlers\MarkdownUrlHandler;

class WebsiteModule extends Module
{
    protected function registerUrlHandlers()
    {
        parent::registerUrlHandlers();

        $this->addUrlHandlers(
            [
                "/" => new MarkdownUrlHandler(),
            ]
        );
    }

    /**
     * Should your module require other modules, they should be returned here.
     */
    public function getModules()
    {
        return [
            new LayoutModule(DefaultLayout::class)
        ];
    }


}