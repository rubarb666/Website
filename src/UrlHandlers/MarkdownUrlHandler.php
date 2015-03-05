<?php

namespace Rhubarb\Website\UrlHandlers;

use Rhubarb\Crown\UrlHandlers\UrlHandler;

require_once "vendor/rhubarbphp/rhubarb/src/UrlHandlers/UrlHandler.php";
require_once "vendor/geeks-dev/php-markdown-extra-extended-stylish/markdown_extended_stylish.php";

class MarkdownUrlHandler extends UrlHandler
{
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

        $rootPath = "docs";

        // If this is the manual - we could be looking at other rhubarb projects.
        if ( preg_match( "/\/manual\/([^\/]+)\//", $url, $match ) )
        {
            $url = str_replace( $match[0], "", $url );
            $rootPath = "vendor/rhubarbphp/".$match[1]."/docs/";
        }

        // Look to see if there's a markdown file at this location.
        if (file_exists($rootPath . $url . ".md")) {
            $markDownRaw = file_get_contents($rootPath . $url . ".md");

            return MarkdownExtended($markDownRaw);
        }
    }
}