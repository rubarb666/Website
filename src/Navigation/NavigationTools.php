<?php

namespace Rhubarb\Website\Navigation;

use Rhubarb\Crown\Request\Request;
use Rhubarb\Website\Settings\MenuSettings;

class NavigationTools
{
    /**
     * Builds a heirarchy of menus from the list of files passed.
     *
     * @param TableOfContentsSource[] $tocs
     */
    public static function buildMenu($tocs)
    {
        $menu = self::makeEntry("", "TOC", null, null);

        $chapter = 1;

        foreach($tocs as $toc){
            $content = file($toc->tocPath);

            $tocEntry = self::makeEntry($toc->urlStub, $toc->title, $menu, $chapter);
            $menu->children[] = $tocEntry;

            $currentMenu = $tocEntry;
            $lastMenu = null;
            $currentIndent = 0;

            foreach($content as $line){
                $indent = strlen($line) - strlen(ltrim($line));

                if ($indent > $currentIndent){
                    $currentMenu = $lastMenu;
                    $currentIndent = $indent;
                } elseif ($indent < $currentIndent ){
                    $currentMenu = $currentMenu->parent;
                    $currentIndent = $indent;
                }

                $parts = explode(":", trim($line));
                if (sizeof($parts) == 1 ){
                    $parts[1] = "";
                }

                $url = $parts[1] ? $toc->urlStub."/".$parts[1] : "";
                $title = trim($parts[0]);

                if (preg_match("/^\. /", $title)){
                    $title = preg_replace("/^\. /", "", $title);

                    $parentWithChapter = self::getParentWithChapter($currentMenu);
                    $parentWithChapter->entryCount++;

                    $subChapter = $parentWithChapter->chapter.".".$parentWithChapter->entryCount;
                } else {
                    $subChapter = false;
                }

                $newEntry = self::makeEntry($url, $title, $currentMenu, $subChapter);

                $currentMenu->children[] = $newEntry;

                $lastMenu = $newEntry;
            }

            $chapter++;
        }

        return $menu;
    }

    private static function getParentWithChapter($parent){
        if ($parent->chapter){
            return $parent;
        }

        if (!$parent->parent){
            return null;
        }

        return self::getParentWithChapter($parent->parent);
    }

    private static function makeEntry($url, $name, $parent, $chapter){
        $entry = new \stdClass();
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