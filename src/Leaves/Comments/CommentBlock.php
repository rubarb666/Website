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

        $comments = Comment::getCommentsForPage($urlPath);

        $array = Array();

        foreach($comments as $comment)
        {
            $replies = Comment::getRepliesForComment($comment->CommentID);
            $array[] =
                [
                    "Comment" => $comment,
                    "Replies" => $replies
                ];
        }

        $this->model->comments = $array;
        
        $this->model->newLikeEvent->attachHandler(function($id)
        {
            Comment::likeComment($id);
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