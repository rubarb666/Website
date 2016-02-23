<?php

namespace Rhubarb\Website\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
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
            new AutoIncrementColumn( "OrganisationID" ),
            new StringColumn( "OrganisationName", 100 )
        );
        $schema->labelColumnName = "OrganisationName";
        return $schema;
    }


}