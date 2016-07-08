<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\TextArea;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Website\Models\Comment;

class CommentBlockView extends View
{
    /**
     * @var CommentBlockModel
     */
    protected $model;

    protected function createSubLeaves()
    {
        $this->registerSubLeaf(
            $newComment = new NewComment("NewComment"),
            $like = new Button("LikeBtn", "Like this post", function () {
                $this->model->newLikeEvent->raise(
                // CommentID
            );
            }, true),
            $reply = new Button("ReplyBtn", "Reply to this post", function () {
                $this->model->newReplyEvent->raise(
                // CommentID
                );
            }),
            $like = new Button("AskQuestion", "Ask a Question", function () {
                $this->model->askQuestionEvent->raise(

                );
            }, true)
        );

        parent::createSubLeaves();
    }

    protected function printViewContent()
    {
        ?>
        <div class="c-block-comments">
            <h2 class="c-block-comments__title">Got a Question?</h2>
            <h2>If your question wasn't answered above, feel free to ask it below</h2>


        <?php


        print $this->leaves["AskQuestion"];
        print $this->leaves["NewComment"];


        foreach ($this->model->comments as $comment) {
            print "<ul class='c-comment-thread'>";
            print $this->getHTMLForComment($comment, 0);
            print "</ul>";
        }

        print '</div>';
        parent::printViewContent();
    }

    private function getHTMLForComment(Comment $comment, $i)
    {
        if($i % 2 == 0)
        {
            $style = 'c-comment';
        }
        else
        {
            $style = 'c-comment c-comment--alt';
        }

        $html = '<li>';
        $html .= "<div class=\"" . $style . "\">";
        $html .= "<div class='c-comment__title'>";
        $html .= "<div class='c-comment__name'>";
        $html .= $comment->Name;
        $html .= "</div>";
        $html .= "<div class='c-comment__date'>";
        $html .= $comment->Date->format("d M Y H:i:s");
        $html .= "</div>";
        $html .= "</div>";
        $html .= "<div class='c-comment__body'>";
        $html .= $comment->Body;
        $html .= "</div>";
        $html .= "<div class ='c-comment__footer'>";
        $html .= "</div>";
        $html .= "</div>";

        if(count($comment->ChildComments))
        {
            $html .= "<ul>";
            foreach ($comment->ChildComments as $reply) {
                $html .= $this->getHTMLForComment($reply, ($i+1));
            }
            $html .= "</ul>";
        }

        $html .= '</li>';

        return $html;
    }
}
