<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Stem\Schema\SolutionSchema;
use Rhubarb\Website\Settings\WebsiteSettings;

class DemoSolutionSchema extends SolutionSchema
{
    public function __construct()
    {
        parent::__construct(0.01);

        $this->addModel( "Contact", '\Rhubarb\Website\Models\Contact' );
        $this->addModel( "Organisation", Organisation::class );
        $this->addModel("Comment", Comment::class);
        $this->addModel("WebsiteSettings", WebsiteSettings::class);
    }

    /**
     * The correct place for implementers to define relationships.
     */
    protected function defineRelationships()
    {
        parent::defineRelationships();

        $this->declareOneToManyRelationships(
            [
                "Organisation" =>
                [
                    "Contacts" => "Contact.OrganisationID"
                ],
                'Comment' =>
                [
                    'ChildComments' => 'Comment.ParentCommentID:ParentCommentCategory'
                ]
            ]
        );
    }
}