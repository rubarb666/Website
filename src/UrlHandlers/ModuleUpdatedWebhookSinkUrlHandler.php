<?php

namespace Rhubarb\Website\UrlHandlers;
use Rhubarb\Crown\Request\JsonRequest;
use Rhubarb\Crown\Request\WebRequest;
use Rhubarb\Crown\Response\JsonResponse;
use Rhubarb\Crown\Response\Response;
use Rhubarb\Crown\UrlHandlers\UrlHandler;


/**
 * Receives an incoming web hook from git hub and updates the appropriate module in the docs folder.
 */
class ModuleUpdatedWebhookSinkUrlHandler extends UrlHandler
{

    /**
     * Return the response if appropriate or false if no response could be generated.
     *
     * @param mixed $request
     * @return bool|Response
     */
    protected function generateResponseForRequest($request = null)
    {
        $response = new JsonResponse();

        /**
         * @var JsonRequest $request
         */
        if ($request->header('X-GitHub-Event',false) === "push"){
            // Parse the body
            $payload = $request->getPayload();

            if ($payload['ref'] !== "/refs/heads/master"){
                goto respond;
            }

            if (stripos($payload['repository->full_name'], 'rhubarbphp/' ) !== 0){
                goto respond;
            }

            $this->updateRepos($payload['repository']['full_name']);
        }

respond:
        return $response;
    }

    private function updateRepos($reposName)
    {
        $reposPath = APPLICATION_ROOT_DIR.'/docs/modules/'.$reposName;

        if (!file_exists($reposPath)){
            exec('git clone https://github.com/'.$reposName.' '.$reposPath);
        } else {
            exec('git --work-tree='.$reposPath.' pull');
        }

        chdir($reposPath);
        exec('composer install --no-dev --ignore-platform-reqs');
    }
}