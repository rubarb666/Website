<?php

namespace Rhubarb\Website\Navigation;

class TableOfContentsSource
{
    public $tocPath;
    public $title;
    public $urlStub;

    public function __construct($tocPath, $title, $urlStub)
    {
        $this->tocPath = $tocPath;
        $this->title = $title;
        $this->urlStub = $urlStub;
    }
}