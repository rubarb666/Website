<?php

namespace Rhubarb\Website\Settings;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Crown\Module;
use Rhubarb\Website\UrlHandlers\MarkdownUrlHandler;

class WebsiteApp extends Module
{
    protected function registerUrlHandlers()
    {
        parent::registerUrlHandlers();

        $this->addUrlHandlers(
            [
                "/" => new MarkdownUrlHandler("docs")
            ]
        );
    }

    protected function initialise()
    {

    }
}

Module::registerModule(new LayoutModule('Rhubarb\\Website\\Layouts\\DefaultLayout'));
Module::registerModule(new WebsiteApp());