<?php

namespace Rhubarb\Website\RestResources;

use Rhubarb\RestApi\Resources\ItemRestResource;
use Rhubarb\RestApi\UrlHandlers\RestHandler;

class DayOfTheWeek extends ItemRestResource
{
    public function get()
    {
        // Start with the 'skeleton'. This gives us a stdClass object with the href already populated.
        $resource = $this->getSkeleton();

        // Silly example but just switch on the ID and return the correct day of the week.
        $days = [ "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" ];

        // $this->id contains the identifier.
        $resource->Day = $days[ $this->id ];

        return $resource;
    }
}