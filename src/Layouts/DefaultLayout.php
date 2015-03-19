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
<link href="/static/css/site.css" rel="stylesheet" type="text/css" />
<link href="/static/css/shThemeEclipse.css" rel="stylesheet" type="text/css" />
<script src="/static/js/shCore.js" type="text/javascript"></script>
<script src="/static/js/shBrushPhp.js" type="text/javascript"></script>
<script src="/static/js/shBrushBash.js" type="text/javascript"></script>
<script src="/static/js/shBrushJScript.js" type="text/javascript"></script>
</head>
</html>
<body>
<div id="top">
    <div class="brace">
        <h1>Rhubarb - a tasty PHP framework</h1>
        <img class="logo" src="/static/images/rhubarb.jpg" height="90" />
    </div>
</div>
<div class="nav">
    <div class="brace">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/about/index">About Rhubarb</a></li>
            <li><a href="/tutorial/index">Get Started</a></li>
            <li><a href="/manual/index">Manual</a></li>
            <li><a href="/contributing">Contributing</a></li>
        </ul>
    </div>
</div>
<div id="content">
    <div class="brace">
        <div class="wrap">
<?php

        parent::printLayout($content);

        ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all()
</script>
</body>
</html><?php
    }
}