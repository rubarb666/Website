<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class CommentBlockModel extends LeafModel
{
    public $comments = array();

    /**
     * @var Event
     */
    public $newLikeEvent;

    /**
     * @var Event
     */
    public $newReplyEvent;

    public function __construct()
    {
        parent::__construct();
        
        $this->newLikeEvent = new Event();
        $this->newReplyEvent = new Event();
    }
}