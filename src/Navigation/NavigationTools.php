<?php

namespace Rhubarb\Website\Navigation;

use Rhubarb\Crown\Request\Request;
use Rhubarb\Website\Settings\MenuSettings;

class NavigationTools
{
    public static function preParseToc($tocPath)
    {
        $content = file($tocPath);
        $processing = true;

        while ($processing) {
            $processing = false;
            $newContent = [];
            foreach ($content as $line) {
                $indent = strlen($line) - strlen(ltrim($line));

                if (preg_match("/[[]([^]]+)+[]]/", $line, $match)) {
                    $subContent = file(APPLICATION_ROOT_DIR.'/'.$match[1]);
                    $processing = true;
                    foreach($subContent as $subContentLine){
                        if (strpos($subContentLine, ':') !== false){
                            $parts = explode(':', $subContentLine);
                            $url = trim($parts[1]);

                            if ($url != "" && $url[0] != "/"){
                                $moduleParts = explode("/", $match[1],4);
                                $module = $moduleParts[2];

                                // As the url is relative we need to ground it back to the right folder.
                                $url = "/manual/".$module."/".$url;

                                $subContentLine = $parts[0].": ".$url;
                            }
                        }
                        $subContentLine = str_repeat(' ', $indent).$subContentLine;
                        $newContent[] = $subContentLine;
                    }
                } else {
                    $newContent[] = $line;
                }
            }

            $content = $newContent;
        }

        return $content;
    }
    /**
     * Builds a heirarchy of menus from the list of files passed.
     */
    public static function buildMenu($tocPath)
    {
        $content = self::preParseToc($tocPath);

        $menu = self::makeEntry("", "TOC", null, null);
        $chapter = 0;

        $currentMenu = $menu;
        $lastMenu = null;
        $lastMenus = [0 => $menu ];

        $currentIndent = 0;

        foreach($content as $line){
            $indent = floor((strlen($line) - strlen(ltrim($line))) / 4);
            if ($currentIndent == 0){
                $chapter++;
            }
            if ($indent > $currentIndent){
                $currentMenu = $lastMenu;
                $currentIndent = $indent;
            } elseif ($indent < $currentIndent ){
                $currentMenu = $lastMenus[$indent];
                $currentIndent = $indent;
            }

            $parts = explode(":", trim($line));
            if (sizeof($parts) == 1 ){
                $parts[1] = "";
            }
            $url = $parts[1] ? trim($parts[1]) : "";
            $title = trim($parts[0]);

            if (preg_match("/^\. /", $title)){
                $title = preg_replace("/^\. /", "", $title);

                $parentWithChapter = self::getParentWithChapter($currentMenu);
                $parentWithChapter->entryCount++;
                $subChapter = $parentWithChapter->chapter . "." . $parentWithChapter->entryCount;

            } else {
                if ($currentIndent == 0) {
                    $subChapter = $chapter;
                } else {
                    $subChapter = false;
                }
            }

            $newEntry = self::makeEntry($url, $title, $currentMenu, $subChapter);
            $currentMenu->children[] = $newEntry;
            $lastMenu = $newEntry;
            $lastMenus[$indent+1] = $newEntry;
        }

        return $menu;
    }

    private static function getParentWithChapter($parent){
        if ($parent->chapter){
            return $parent;
        }

        if (!$parent->parent){
            return $parent;
        }

        return self::getParentWithChapter($parent->parent);
    }

    private static function makeEntry($url, $name, $parent, $chapter){
        $entry = new MenuItem();
        $entry->url = $url;
        $entry->name = $name;
        $entry->parent = $parent;
        $entry->chapter = $chapter;
        $entry->children = [];
        $entry->entryCount = 0;

        $request = Request::current();

        if ($request->uri == $url){
            $settings = MenuSettings::singleton();
            $settings->currentChapter = $chapter;
        }

        return $entry;
    }

    public static function printMenu($parent, $indent)
    {
        $request = Request::current();

        if ( $indent == 2 && stripos($request->uri, $parent->url) === false ){
            return;
        }

        $x = 1;
        $first = true;

        foreach($parent->children as $child){

            $current = $request->uri == $child->url ? " current" : "";
            $firstClass = ($first) ? " first" : "";
            $first = false;

            print "<li class=\"indent-".($indent+1)." $current $firstClass \">";

            $name = $child->name;

            if ( $child->chapter ){
                $name = $child->chapter.". ".$name;
            }

            if ($child->url != ""){
                print "<a href='".$child->url."#content'>".$name."</a>";
            } else {
                print $name;
            }

            print "</li>";

            self::printMenu($child, $indent+1);

            $x++;
        }
    }
}

class MenuItem
{
    public $url;
    public $children = [];

    public function containsUrl($url)
    {
        if ($this->url == $url){
            return true;
        }

        foreach($this->children as $child){
            if ($child->containsUrl($url)) {
                return true;
            }
        }

        return false;
    }
}