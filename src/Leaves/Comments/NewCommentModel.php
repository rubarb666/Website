<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class NewCommentModel extends LeafModel
{
    /**
     * @var Event
     */
    public $newCommentEvent;

    public function __construct()
    {
        parent::__construct();

        $this->newCommentEvent = new Event();
    }
}