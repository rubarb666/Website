<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Request\WebRequest;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Website\Models\Comment;

class NewComment extends Leaf
{
    /**
    * @var NewCommentModel
    */
    protected $model;

    protected function getViewClass()
    {
        return NewCommentView::class;
    }

    protected function createModel()
    {
        $model = new NewCommentModel();

        // If your model has events you want to listen to you should attach the handlers here
        // e.g.
        // $model->selectedUserChangedEvent->attachListener(function(){ ... });

        return $model;
    }

    protected function onModelCreated()
    {
        $this->model->newCommentEvent->attachHandler(function () {

            /** @var WebRequest $request */
            $request = WebRequest::current();
            $urlPath = $request->urlPath;

            $name = $this->model->CommentName;
            $email = $this->model->CommentEmail;
            $body = $this->model->CommentBody;

            //TODO: Raise in event
            $parentId = 0;


            if ($body) {
                $comment = new Comment();
                if (!$name) {
                    $comment->Name = "Anonymous";
                } else {
                    $comment->Name = $name;
                }
                $comment->Email = $email;
                $comment->Body = $body;
                $comment->ParentCommentID = $parentId;
                $comment->UrlPath = $urlPath;
                $comment->save();
            }
        });

        parent::onModelCreated();
    }
}