<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Leaf\Controls\Common\Buttons\Button;
use Rhubarb\Leaf\Controls\Common\Text\TextArea;
use Rhubarb\Leaf\Controls\Common\Text\TextBox;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;
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
            $submit = new Button("SubmitBtn", "Submit your question", function (){
                $this->model->newCommentEvent->raise();
            }, true)
        );

        $name->setMaxLength(50);
        $name->setPlaceholderText("Joe Bloggs");
        $name->setLabel("Name:");

        $email->setMaxLength(50);
        $email->setPlaceholderText("email@address.com");
        $email->setLabel("Email:");

        $body->setMaxLength(10000);
        $body->setPlaceholderText("Rhubarb Crumble or Rhubarb Tart?");
        $body->setLabel("Question:");

        $submit->addCssClassNames("c-comment__submit-button");
    }

    protected function printViewContent()
    {
        print "<head><script src='https://www.google.com/recaptcha/api.js'></script></head>";
        print "<div class='c-comment__submission'>";
        print $this->leaves["CommentName"]->getLabel();
        print $this->leaves["CommentName"];
        print $this->leaves["CommentEmail"]->getLabel();
        print $this->leaves["CommentEmail"];
        print $this->leaves["CommentBody"]->getLabel();
        print $this->leaves["CommentBody"];
        print '<div class="c-comment__submission--captcha"><div class="g-recaptcha" data-sitekey = "6LeWkyQTAAAAAB__o0t5SdNZVOlgrbrEcV7wtQeM" ></div></div>';
        if ($this->model->newCommentError) {
            print "<div class='c-comment__submission--error'>" . $this->model->newCommentError . "</div>";
        }

        print $this->leaves["SubmitBtn"];
        print "</div>";
    }

    public function getDeploymentPackage()
    {
        return new LeafDeploymentPackage(__DIR__ . '/NewCommentViewBridge.js');
    }

    protected function getViewBridgeName()
    {
        return 'NewCommentViewBridge';
    }


}