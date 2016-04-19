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
                "/gallery/validation/town-crier/" => new ClassMappedUrlHandler(\Rhubarb\Website\Presenters\Validation\TownCrier\IndexPresenter::class),
                "/gallery/validation/the-reporter/" => new ClassMappedUrlHandler(\Rhubarb\Website\Presenters\Validation\TheReporter\IndexPresenter::class),
                "/gallery/validation/the-eager-assistant/" => new ClassMappedUrlHandler(\Rhubarb\Website\Presenters\Validation\TheEagerAssistant\IndexPresenter::class),
                "/" => new MarkdownUrlHandler(),
                "/api" => new RestApiRootHandler(
                    ApiDescriptionResource::class,
                    [
                        "/days-of-the-week" => new RestCollectionHandler( '\Rhubarb\Website\RestResources\DaysOfTheWeek' ),
                        "/contacts" => new RestCollectionHandler( '\Rhubarb\Website\RestResources\ContactResource' ),
                    ] )
            ]
        );
    }

    protected function initialise()
    {
        $organisation = new Organisation();
        $organisation->OrganisationName = "Acme Co. Ltd.";
        $organisation->save();

        $contact = new Contact();
        $contact->Name = "John Smith";
        $contact->DateOfBirth = "today";
        $contact->save();

        $contact = new Contact();
        $contact->Name = "Peter Salmon";
        $contact->DateOfBirth = "yesterday";
        $contact->save();

        $contact = new Contact();
        $contact->Name = "Claire Blackwood";
        $contact->DateOfBirth = "last week";
        $contact->OrganisationID = $organisation->UniqueIdentifier;
        $contact->save();

        SolutionSchema::registerSchema( "Demo", '\Rhubarb\Website\Models\DemoSolutionSchema' );

        ModelRestResource::registerModelToResourceMapping( "Organisation", OrganisationResource::class );

        include_once("settings/site.config.php");
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