<?php

namespace Rhubarb\Website\Navigation;

class NavigationTools
{
    /**
     * Builds a heirarchy of menus from the list of files passed.
     *
     * @param TableOfContentsSource[] $tocs
     */
    public static function buildMenu($tocs)
    {
        $menu = self::makeEntry("", "TOC", null);

        foreach($tocs as $toc){
            $content = file($toc->tocPath);

            $tocEntry = self::makeEntry($toc->urlStub, $toc->title, $menu);
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
                $newEntry = self::makeEntry($url, $parts[0], $currentMenu);
                $currentMenu->children[] = $newEntry;

                $lastMenu = $newEntry;
            }
        }

        return $menu;
    }

    private static function makeEntry($url, $name, $parent){
        $entry = new \stdClass();
        $entry->url = $url;
        $entry->name = $name;
        $entry->parent = $parent;
        $entry->children = [];
        return $entry;
    }
}