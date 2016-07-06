<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\TextArea;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Views\View;

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
            })
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

        print $this->leaves["NewComment"];

        foreach ($this->model->comments as $comments) {
            print "<div class='c-comment'>";
            print "<div class='c-comment__title'>";
            print "<div class='c-comment__name'>";
            print $comments["Comment"]->Name;
            print "</div>";
            print "<div class='c-comment__date'>";
            print $comments["Comment"]->Date->format("d-m-Y H:i:s");
            print "</div>";
            print "</div>";
            print "<div class='c-comment__body'>";
            print $comments["Comment"]->Body;
            print "</div>";
            print "<div class='c-comment__footer'>";
//            print "👍" . $comment->Likes;
//            print $this->leaves["LikeBtn"];
//            print $this->leaves["ReplyBtn"];
            print "</div>";
            print "</div>";
            foreach ($comments["Replies"] as $reply) {
                print "<div class='c-comment c-comment--reply'>";
                print "<div class='c-comment__title'>";
                print "<div class='c-comment__name'>";
                print $reply->Name;
                print "</div>";
                print "<div class='c-comment__date'>";
                print $reply->Date->format("d-m-Y H:i:s");
                print "</div>";
                print "</div>";
                print "<div class='c-comment__body'>";
                print $reply->Body;
                print "</div>";
                print "</div>";
            }
        }

        print '</div>';
        parent::printViewContent();
    }
}
