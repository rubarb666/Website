<?php

namespace Rhubarb\Website\RestResources;

use Rhubarb\Crown\DateTime\RhubarbDateTime;
use Rhubarb\RestApi\Exceptions\RestImplementationException;
use Rhubarb\RestApi\Resources\CollectionRestResource;
use Rhubarb\RestApi\Resources\ItemRestResource;

class DaysOfTheWeek extends CollectionRestResource
{
    protected function getItems($from, $to, RhubarbDateTime $since = null)
    {
        // Ignoring $since as it has no bearing in this case.
        $items = [];

        for( $x = max( $from, 0 ); $x < min( $to, 6 ); $x++ ){
            $dayOfTheWeekResource = $this->getItemResource($x);
            $items[] = $dayOfTheWeekResource->get();
        }

        return [ $items, count($items) ];
    }


    /**
     * Returns the ItemRestResource for the $resourceIdentifier contained in this collection.
     *
     * @param $resourceIdentifier
     * @return ItemRestResource
     * @throws RestImplementationException Thrown if the item could not be found.
     */
    public function createItemResource($resourceIdentifier)
    {
        return new DayOfTheWeek($resourceIdentifier);
    }
}