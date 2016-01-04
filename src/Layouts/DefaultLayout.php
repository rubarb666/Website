<?php

namespace Rhubarb\Website\Layouts;

require_once "vendor/rhubarbphp/rhubarb/src/Layout/Layout.php";

use Rhubarb\Crown\Layout\Layout;

class DefaultLayout extends Layout
{
    protected function printLayout($content)
    {
        ?><html>
<title>Rhubarb PHP</title>
<head>
<link href="/static/css/screen.css" rel="stylesheet" type="text/css" />
<link href="/static/css/shThemeEclipse.css" rel="stylesheet" type="text/css" />
<script src="/static/js/shCore.js" type="text/javascript"></script>
<script src="/static/js/shBrushPhp.js" type="text/javascript"></script>
<script src="/static/js/shBrushBash.js" type="text/javascript"></script>
<script src="/static/js/shBrushJScript.js" type="text/javascript"></script>
</head>
</html>
<body>
<div class="c-page">
    <div id="top" class="c-global-header">
        <header>
            <a href="/"><img class="c-site-logo" src="/static/images/rhubarb-logo.svg"></a>
            <h1>Rhubarb</h1>
        </header>
        <nav class="c-global-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about/index">About Rhubarb</a></li>
                <li><a href="/tutorial/index">Get Started</a></li>
                <li><a href="/manual/index">Manual</a></li>
                <li><a href="/contributing">Contributing</a></li>
            </ul>
        </nav>
    </div>
    <main>
<!--    <div class="c-band u-fill--shade"></div>-->
    <div id="content" class="c-band c-main">
        <div class="c-main-content">
    <?php

            parent::printLayout($content);

            ?>
        </div>
    </div>
    </main>

<footer>
    <div class="c-band c-global-footer">
    a simple, all-round PHP framework.
    </div>
</footer>
</div>
<script type="text/javascript">
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all()
</script>
</body>
</html><?php
    }
}