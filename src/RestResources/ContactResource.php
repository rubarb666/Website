<?php

namespace Rhubarb\Website\RestResources;

use Rhubarb\RestApi\Resources\ModelRestResource;

class ContactResource extends ModelRestResource
{
    /**
     * Returns the name of the model to use for this resource.
     *
     * @return string
     */
    public function getModelName()
    {
        return "Contact";
    }

    public function getColumns()
    {
        // Let's keep the ID and label
        $columns = parent::getColumns();
        // Now add another property to our resource:
        $columns[] = "Organisation";
        return $columns;
    }
}