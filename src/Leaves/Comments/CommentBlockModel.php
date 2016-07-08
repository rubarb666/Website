<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class CommentBlockModel extends LeafModel
{
    public $comments = array();
    public $visibility;

    /**
     * @var Event
     */
    public $newLikeEvent;

    /**
     * @var Event
     */
    public $newReplyEvent;

    /**
     * @var Event
     */
    public $askQuestionEvent;

    public function __construct()
    {
        parent::__construct();

        $this->newLikeEvent = new Event();
        $this->newReplyEvent = new Event();
        $this->askQuestionEvent = new Event();
    }
}