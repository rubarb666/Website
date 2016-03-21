<?php

namespace Rhubarb\Website\Layouts;

require_once "vendor/rhubarbphp/rhubarb/src/Layout/Layout.php";

use Rhubarb\Crown\Application;use Rhubarb\Crown\Layout\Layout;use Rhubarb\Crown\Request\Request;use Rhubarb\Crown\String\StringTools;use Rhubarb\Website\Navigation\NavigationTools;use Rhubarb\Website\Navigation\TableOfContentsSource;

class DefaultLayout extends Layout
{
    protected function printLayout($content)
    {
        ?><html>
<title>Rhubarb PHP</title>
<head>
<link href="/static/css/screen.css" rel="stylesheet" type="text/css" />
<link href="/static/css/dev.css" rel="stylesheet" type="text/css" />
<link href="/static/css/shThemeEclipse.css" rel="stylesheet" type="text/css" />
<script src="/static/js/shCore.js" type="text/javascript"></script>
<script src="/static/js/shBrushPhp.js" type="text/javascript"></script>
<script src="/static/js/shBrushBash.js" type="text/javascript"></script>
<script src="/static/js/shBrushJScript.js" type="text/javascript"></script>

<link rel="apple-touch-icon" sizes="57x57" href="/static/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/static/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/static/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/static/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/static/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/static/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/static/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/static/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/static/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/static/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/static/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="/static/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/static/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/static/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/static/manifest.json">
<link rel="mask-icon" href="/static/safari-pinned-tab.svg" color="#ef15e4">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/static/mstile-144x144.png">
<meta name="theme-color" content="#333333">

</head>
</html>
<?php
$request = Request::current();
?>
<body <?=(StringTools::contains($request->uri, "manual")) ? 'class="l-docs"' : '';?>>
<div class="c-page">
    <div id="top" class="c-global-header">
        <header>
            <a href="/"><img class="c-site-logo" src="/static/images/rhubarb-logo.svg"></a>
            <h1>Rhubarb</h1>
        </header>
        <nav class="c-global-nav">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Rhubarb</a></li>
                <li><a href="/tutorial/index">Get Started</a></li>
                <li><a href="/manual/index">Manual</a></li>
                <li><a href="/contributing">Contributing</a></li>
            </ul>
        </nav>
    </div>
    <main>
<!--    <div class="c-band u-fill--shade"></div>-->
    <div id="content" class="c-band c-main">
        <div class="c-manual-entries">
        <?php

        $request = Application::current()->request();

        if (stripos($request->uri, "/manual/") === 0){
            $menu = NavigationTools::buildMenu(
            [
                new TableOfContentsSource( __DIR__."/../../vendor/rhubarbphp/rhubarb/docs/toc.txt", "The Basics", "/manual/rhubarb" ),
                new TableOfContentsSource( __DIR__."/../../vendor/rhubarbphp/module-stem/docs/toc.txt", "The Basics", "/manual/module-stem/" )
            ]);

            $first = true;

            $printMenu = function($parent, $indent, $menuPrinter) use ($request, &$first){

                if ( $indent == 2 && stripos($request->uri, $parent->url) === false ){
                    return;
                }

                foreach($parent->children as $child){

                    $current = $request->uri == $child->url ? " current" : "";
                    $firstClass = ($first) ? " first" : "";
                    $first = false;

                    print "<li class=\"indent-".($indent+1)." $current $firstClass \">";

                    if ($child->url != ""){
                        print "<a href='".$child->url."#content'>".$child->name."</a>";
                    } else {
                        print $child->name;
                    }

                    print "</li>";

                    $menuPrinter($child, $indent+1, $menuPrinter);
                }
            };

            ?><ul class="c-menu"><?php
            foreach($menu->children as $item){
                $printMenu($item, 0, $printMenu);
            }
            ?></ul>
            <?php
        }

        ?>
        </div>
        <div class="c-main-content">
            <div class="c-main-content__inner">
                <?php
                parent::printLayout($content);
                ?>
            </div>
        </div>
    </div>
    </main>

<footer>
    <div class="c-band c-global-footer">
    the tasty PHP framework.
    </div>
</footer>
</div>
<script type="text/javascript">

    var codes = document.querySelectorAll("code");

    for(var i = 0; i<codes.length; i++){
        if (codes[i].classList.contains("language-php")){
            codes[i].parentNode.className = "brush: php";

            codes[i].parentNode.innerHTML = codes[i].innerHTML;
        }
    }

    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all()
</script>
</body>
</html><?php
    }
}