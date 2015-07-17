<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\Date;
use Rhubarb\Stem\Schema\Columns\ForeignKey;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

class Contact extends Model
{

    /**
     * Returns the schema for this data object.
     *
     * @return \Rhubarb\Stem\Schema\ModelSchema
     */
    protected function createSchema()
    {
        $schema = new ModelSchema("Contact");
        $schema->addColumn(
            new AutoIncrement(3),
            new String( "Name", 100 ),
            new Date( "DateOfBirth" ),
            new ForeignKey( "OrganisationID" )
        );

        $schema->labelColumnName = "Name";

        return $schema;
    }
}