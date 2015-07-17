<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrement;
use Rhubarb\Stem\Schema\Columns\String;
use Rhubarb\Stem\Schema\ModelSchema;

class Organisation extends Model
{

    /**
     * Returns the schema for this data object.
     *
     * @return \Rhubarb\Stem\Schema\ModelSchema
     */
    protected function createSchema()
    {
        $schema = new ModelSchema("Organisation");
        $schema->addColumn(
            new AutoIncrement( "OrganisationID" ),
            new String( "OrganisationName", 100 )
        );
        $schema->labelColumnName = "OrganisationName";
        return $schema;
    }


}