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
<link href="/static/css/shThemeRDark.css" rel="stylesheet" type="text/css" />
<script src="/static/js/shCore.js" type="text/javascript"></script>
<script src="/static/js/shBrushPhp.js" type="text/javascript"></script>
<script src="/static/js/shBrushBash.js" type="text/javascript"></script>
<script src="/static/js/shBrushJScript.js" type="text/javascript"></script>
</head>
</html>
<body>
<ul>
    <li>Home</li>
    <li>About Rhubarb</li>
    <li>Get Started</li>
    <li>Manual</li>
    <li>Contributing</li>
</ul>
<?php

parent::printLayout($content);

?>
<script type="text/javascript">
     SyntaxHighlighter.all()
</script>
</body>
</html><?php
    }
}