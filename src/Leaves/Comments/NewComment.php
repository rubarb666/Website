<?php

namespace Rhubarb\Website\Leaves\Comments;

use Rhubarb\Crown\Http\HttpClient;
use Rhubarb\Crown\Http\HttpRequest;
use Rhubarb\Crown\Request\WebRequest;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Website\Models\Comment;
use Rhubarb\Website\Settings\WebsiteSettings;
use Symfony\Component\Yaml\Escaper;

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

            $name = strip_tags($this->model->CommentName);
            $email = strip_tags($this->model->CommentEmail);
            $body = strip_tags($this->model->CommentBody);

            //TODO: Raise in event
            $parentId = 0;

            $payload = $request->getPayload();

            $secret = WebsiteSettings::find(
                new Equals("SettingName", "GoogleSecret")
            );


            $gcaptcha =
                [
                    "secret" => $secret[0]->SettingValue,
                    "response" => $payload["g-recaptcha-response"],
                    "remoteip" => $_SERVER['REMOTE_ADDR']
                ];

            $client = HttpClient::getDefaultHttpClient();
            $httpReq = new HttpRequest("https://www.google.com/recaptcha/api/siteverify", "post", $gcaptcha);
            $response = $client->getResponse($httpReq);
            $responseBody = json_decode($response->getResponseBody());

            if ($responseBody->success) {
                if ($body) {
                    $comment = new Comment();
                    if (!$name) {
                        $i = rand(0, 3);
                        $j = rand(0, 3);
                        $forename = ["Goat", "Cat", "Penguin", "Eagle"];
                        $surname = ["Bay", "Oak", "Beech", "Walnut"];
                        $comment->Name = $forename[$i] . " " . $surname[$j];
                    } else {
                        $comment->Name = $name;
                    }
                    $comment->Email = $email;
                    $comment->Body = $body;
                    $comment->ParentCommentID = $parentId;
                    $comment->UrlPath = $urlPath;
                    $comment->save();
                } else {
                    $this->model->newCommentError = "⚠️ Sorry, there was a problem saving your comment ⚠️";
                }
            }
            else
            {
                $this->model->newCommentError = "⚠️ The captcha was entered incorrectly, please try again ⚠️";
            }
        });

        parent::onModelCreated();
    }
}