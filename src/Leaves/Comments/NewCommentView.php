<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\TextArea;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Views\View;

class NewCommentView extends View
{
    /**
     * @var NewCommentModel
     */
    protected $model;

    protected function createSubLeaves()
    {
        $this->registerSubLeaf(
            $name = new TextBox("CommentName"),
            $email = new TextBox("CommentEmail"),
            $body = new TextArea("CommentBody"),
            $submit = new Button("SubmitBtn", "Ask your question", function () {
                $this->model->newCommentEvent->raise(
                // Parent Coment ID
                );
            }, true)
        );

        $name->setMaxLength(50);
        $name->setPlaceholderText("Joe Bloggs");
        $name->setLabel("Name:");

        $email->setMaxLength(50);
        $email->setPlaceholderText("email@address.com");
        $email->setLabel("Email:");

        $body->setMaxLength(50);
        $body->setPlaceholderText("Rhubarb Crumble or Rhubarb Tart?");
        $body->setLabel("Question:");

        $submit->addCssClassNames("c-comment__submit-button");
    }

    protected function printViewContent()
    {
        print "<div class='c-comment__submission'>";
        print $this->leaves["CommentName"]->getLabel();
        print $this->leaves["CommentName"];
        print $this->leaves["CommentEmail"]->getLabel();
        print $this->leaves["CommentEmail"];
        print $this->leaves["CommentBody"]->getLabel();
        print $this->leaves["CommentBody"];
        print $this->leaves["SubmitBtn"];
        print "</div>";
    }
}