<?php

namespace Rhubarb\Website\RestResources;

use Rhubarb\RestApi\Resources\ModelRestResource;

class OrganisationResource extends ModelRestResource
{
    /**
     * Returns the name of the model to use for this resource.
     *
     * @return string
     */
    public function getModelName()
    {
        return "Organisation";
    }
/*
    protected function getHref()
    {
        if ( $this->model ){
            return "/organisations/".$this->model->UniqueIdentifier;
        }

        return "/organisations";
    }*/
}