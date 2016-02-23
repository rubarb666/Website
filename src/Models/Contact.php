<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateColumn;
use Rhubarb\Stem\Schema\Columns\ForeignKeyColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
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
            new AutoIncrementColumn(3),
            new StringColumn( "Name", 100 ),
            new DateColumn( "DateOfBirth" ),
            new ForeignKeyColumn( "OrganisationID" )
        );

        $schema->labelColumnName = "Name";

        return $schema;
    }
}