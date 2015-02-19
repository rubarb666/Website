<?php

namespace Rhubarb\Website\UrlHandlers;

use Rhubarb\Crown\UrlHandlers\UrlHandler;

require_once "vendor/rhubarbphp/rhubarb/src/UrlHandlers/UrlHandler.php";
require_once "vendor/geeks-dev/php-markdown-extra-extended-stylish/markdown_extended_stylish.php";

class MarkdownUrlHandler extends UrlHandler
{
    private $rootPath;

    function __construct($rootPath, $childUrlHandlers = [])
    {
        $this->rootPath = $rootPath;

        parent::__construct($childUrlHandlers);
    }

    /**
     * Return the response if appropriate or false if no response could be generated.
     *
     * @param mixed $request
     * @return bool
     */
    protected function generateResponseForRequest($request = null)
    {
        $url = $request->UrlPath;

        if ($url[strlen($url) - 1] == "/") {
            $url = $url . "index";
        }

        // Look to see if there's a markdown file at this location.
        if (file_exists($this->rootPath . $url . ".md")) {
            $markDownRaw = file_get_contents($this->rootPath . "/" . $url . ".md");

            return MarkdownExtended($markDownRaw);
        }
    }
}