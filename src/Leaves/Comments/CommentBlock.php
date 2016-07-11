<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Request\WebRequest;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\Leaves\LeafModel;
use Rhubarb\Website\Models\Comment;

class CommentBlock extends Leaf
{
    /**
     * @var CommentBlockModel
     */
    protected $model;

    /**
     * Returns the name of the standard view used for this leaf.
     *
     * @return string
     */
    protected function getViewClass()
    {
        return CommentBlockView::class;
    }

    protected function onModelCreated()
    {
        /** @var WebRequest $request */
        $request = WebRequest::current();
        $urlPath = $request->urlPath;
        $this->model->visibility = "";
        try {
            $comments = Comment::getCommentsForPage($urlPath);
            $this->model->comments = $comments;
        } catch (\Exception $ex) {
            new Comment(1);
        }

        $this->model->askQuestionEvent->attachHandler(function()
        {
            // Show the new comment dialogue
        });

        $this->model->replyToCommentEvent->attachHandler(function()
        {
            // Reply to the comment
        });
    }

    /**
     * Should return a class that derives from LeafModel
     *
     * @return LeafModel
     */
    protected function createModel()
    {
        return new CommentBlockModel();
    }
}