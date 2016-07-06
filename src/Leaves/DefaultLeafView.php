<?php
namespace Rhubarb\Website\Leaves;

use ParsedownExtra;
use Rhubarb\Crown\PhpContext;
use Rhubarb\Crown\Request\Request;
use Rhubarb\Crown\Request\WebRequest;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Website\Leaves\Comments\CommentBlock;
use Rhubarb\Website\Navigation\NavigationTools;
use Rhubarb\Website\Navigation\TableOfContentsSource;

class DefaultLeafView extends View
{
    /**
    * @var DefaultLeafModel
    */
    protected $model;

    protected function createSubLeaves()
    {
        $this->registerSubLeaf(
          $commentBlock = new CommentBlock("CommentBlock")
        );
    }


    protected function printViewContent()
    {
        /** @var WebRequest $request */
        $request = WebRequest::current();

        $url = $request->urlPath;

        if ($url[strlen($url) - 1] == "/") {
            $url = $url . "index";
        }

        $rootPath = "docs";

        // If this is the manual - we could be looking at other rhubarb projects.
        if (preg_match("/\/manual\/([^\/]+)\//", $url, $match)) {
            $url = str_replace($match[0], "", $url);
            $rootPath = "docs/modules/" . $match[1] . "/docs/";
        }

        $rootPath = APPLICATION_ROOT_DIR . "/" . $rootPath;

        // Look to see if there's a markdown file at this location.
        if (file_exists($rootPath . $url . ".md")) {
            $markDownRaw = file_get_contents($rootPath . $url . ".md");

            while (preg_match("/{menu:([^}]+)}/", $markDownRaw, $match)) {

                $menu = NavigationTools::buildMenu(
                    [
                        new TableOfContentsSource($match[1], "", "/manual/rhubarb/")
                    ]
                );

                ob_start();

                ?>
                <ul class="c-menu"><?php

                foreach ($menu->children as $child) {
                    NavigationTools::printMenu($menu->children[0], 0);
                }

                ?></ul><?php

                $html = ob_get_clean();


                $markDownRaw = str_replace($match[0], $html, $markDownRaw);
            }

            $parseDown = new ParsedownExtra();
            print $parseDown->text($markDownRaw);
        }


        if (stripos($request->urlPath, "/manual/") === 0) {
            print $this->leaves["CommentBlock"];
        }

        print "";
    }
}