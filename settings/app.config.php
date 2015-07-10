<?php

namespace Rhubarb\Website\Settings;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\RestApi\UrlHandlers\RestCollectionHandler;
use Rhubarb\Website\RestResources\DaysOfTheWeek;
use Rhubarb\Website\UrlHandlers\MarkdownUrlHandler;

class WebsiteApp extends Module
{
    protected function registerUrlHandlers()
    {
        parent::registerUrlHandlers();

        $this->addUrlHandlers(
            [
                "/days-of-the-week" => new RestCollectionHandler( '\Rhubarb\Website\RestResources\DaysOfTheWeek' ),
                "/" => new MarkdownUrlHandler()
            ]
        );
    }

    protected function initialise()
    {

    }
}

Module::registerModule(new LayoutModule('Rhubarb\\Website\\Layouts\\DefaultLayout'));
Module::registerModule(new WebsiteApp());