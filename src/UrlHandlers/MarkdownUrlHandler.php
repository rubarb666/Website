<?php

namespace Rhubarb\Website\UrlHandlers;

use ParsedownExtra;
use Rhubarb\Crown\Logging\Log;
use Rhubarb\Crown\Request\Request;
use Rhubarb\Crown\Response\HtmlResponse;
use Rhubarb\Crown\UrlHandlers\UrlHandler;
use Rhubarb\Website\Navigation\NavigationTools;
use Rhubarb\Website\Navigation\TableOfContentsSource;
use Rhubarb\Website\Parsedown\RhubarbParsedown;

require_once VENDOR_DIR."/rhubarbphp/rhubarb/src/UrlHandlers/UrlHandler.php";

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
        $url = $request->urlPath;

        if ($url[strlen($url) - 1] == "/") {
            $url = $url . "index";
        }

        $rootPath = "docs";

        // If this is the manual - we could be looking at other rhubarb projects.
        if ( preg_match( "/\/manual\/([^\/]+)\//", $url, $match ) &&
             $url != "/manual/scaffolds/index")
        {
            $url = str_replace( $match[0], "", $url );
            $rootPath = "docs/modules/".$match[1]."/docs/";
        }

        $rootPath = APPLICATION_ROOT_DIR."/".$rootPath;

        // Is this an example leaf?
        $parts = explode("/",$url);

        if ($parts[0] == "examples"){
            if (file_exists($rootPath . $url . ".php"))  {
                $html = RhubarbParsedown::getHtmlForDemo($rootPath . $url . ".php", Request::current());
                return $html;
            }
        }

        // Look to see if there's a markdown file at this location.
        if (file_exists($rootPath . $url . ".md")) {
            $markDownRaw = file_get_contents($rootPath . $url . ".md");

            while(preg_match("/{menu:([^}]+)}/", $markDownRaw, $match)){

                $menu = NavigationTools::buildMenu(
                    [
                        new TableOfContentsSource($match[1], "", "/manual/rhubarb/")
                    ]
                );

                ob_start();

                ?><ul class="c-menu"><?php

                foreach($menu->children as $child) {
                    NavigationTools::printMenu($menu->children[0], 0);
                }

                ?></ul><?php

                $html = ob_get_clean();


                $markDownRaw = str_replace($match[0],$html, $markDownRaw);
            }

            $parseDown = new RhubarbParsedown($rootPath);
            return $parseDown->text($markDownRaw);
        }

        return "";
    }
}
