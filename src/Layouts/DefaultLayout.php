<?php

namespace Rhubarb\Website\Layouts;

require_once VENDOR_DIR."/rhubarbphp/rhubarb/src/Layout/Layout.php";

use Rhubarb\Crown\Application;
use Rhubarb\Crown\Html\ResourceLoader;use Rhubarb\Crown\Layout\Layout;
use Rhubarb\Crown\Request\Request;
use Rhubarb\Crown\String\StringTools;
use Rhubarb\Website\Navigation\NavigationTools;
use Rhubarb\Website\Navigation\TableOfContentsSource;
use Rhubarb\Website\Settings\MenuSettings;

class DefaultLayout extends Layout
{
    protected function printLayout($content)
    {
        ?><html>
<title>Rhubarb PHP</title>
<head>

<link href="/static/css/screen.css" rel="stylesheet" type="text/css" />
<link href="/static/css/gallery.css" rel="stylesheet" type="text/css" />
<link href="/static/css/dev.css" rel="stylesheet" type="text/css" />

<link href="/static/prism/prism.css" rel="stylesheet" type="text/css" />
<script src="/static/prism/prism.js" type="text/javascript"></script>

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
<style type="text/css">

@import url("http://fast.fonts.net/t/1.css?apiType=css&projectid=b00cbac7-a878-4c08-9abc-c0d909f94713");
    @font-face{
    font-family:"Avenir Next LT W04 Bold";
    src:url("/static/fonts/6ff8ab07-ccb4-4a91-8f0f-2bd4367902e8.eot?#iefix");
    src:url("/static/fonts/6ff8ab07-ccb4-4a91-8f0f-2bd4367902e8.eot?#iefix") format("eot"),url("/static/fonts/91799b0e-0ef8-446e-b274-5509412e1242.woff2") format("woff2"),url("/static/fonts/97fb5311-bdbd-46bc-bf69-3bcf8c744cda.woff") format("woff"),url("/static/fonts/88093bd3-b377-4278-8abe-8460dd24d0e8.ttf") format("truetype"),url("/static/fonts/0fde1539-69df-4e3d-83ef-ae23d10dd2a5.svg#0fde1539-69df-4e3d-83ef-ae23d10dd2a5") format("svg");
    }
    @font-face{
    font-family:"AvenirNextLTW01-Regular";
    src:url("/static/fonts/e9167238-3b3f-4813-a04a-a384394eed42.eot?#iefix");
    src:url("/static/fonts/e9167238-3b3f-4813-a04a-a384394eed42.eot?#iefix") format("eot"),url("/static/fonts/2cd55546-ec00-4af9-aeca-4a3cd186da53.woff2") format("woff2"),url("/static/fonts/1e9892c0-6927-4412-9874-1b82801ba47a.woff") format("woff"),url("/static/fonts/46cf1067-688d-4aab-b0f7-bd942af6efd8.ttf") format("truetype"),url("/static/fonts/52a192b1-bea5-4b48-879f-107f009b666f.svg#52a192b1-bea5-4b48-879f-107f009b666f") format("svg");
    }

    </style>
    <?=ResourceLoader::getResourceInjectionHtml();?>
</head>
</html>
<?php
$request = Request::current();
?>
<body <?=(StringTools::contains($request->uri, "manual")) ? 'class="l-docs"' : '';?>>
<div class="c-page">
    <div id="top" class="c-global-header c-band">
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
    <main class="c-main">

    <div id="content" class="c-band">
        <div class="c-manual-entries">
        <?php

        $request = Application::current()->request();

        if (stripos($request->urlPath, "/manual/") === 0){

            $menu = NavigationTools::buildMenu(APPLICATION_ROOT_DIR."/docs/manual/toc.txt");

            ?><ul class="c-menu"><?php
            $x = 1;

            $first = true;

            foreach($menu->children as $item){

                $firstClass = ($first) ? " first" : "";
                $first = false;

                $url = $item->url;

                if ((!$url) && isset($item->children) && (sizeof($item->children) > 0)){
                    //$url = $item->children[0]->url;
                }

                // Is the current url this one or one of the children? If so open the menu and children.
                if ($item->containsUrl($request->urlPath)){
                    print '<li class="chapter open'.$firstClass.'">'.$item->chapter.". ".$item->name.'</li>';
                    NavigationTools::printMenu($item, 0);
                } else {
                    print '<li class="chapter closed'.$firstClass.'"><a href="'.$url.'">'.$item->chapter.". ".$item->name.'</a></li>';
                }

                $x++;
            }
            ?></ul>
            <?php
        }

        ?>
        </div>
        <div class="c-main-content">
            <div class="c-main-content__inner">
                <?php

                $settings = MenuSettings::singleton();
                if ($settings->currentChapter){
                    $content = str_replace("<h1>", "<h1>".$settings->currentChapter.". ", $content);
                }

                parent::printLayout($content);
                ?>
            </div>
        </div>
    </div>
    </main>

<footer class="c-global-footer">
    <div class="c-band">
    the tasty PHP framework.
    </div>
</footer>
</div>
<script type="text/javascript">

    var tabs = document.querySelectorAll('.js-tabs');

    for(var i = 0; i < tabs.length; i++){
        var tab = tabs[i];

        var panes = tab.querySelectorAll('.js-tab');

        if (panes.length > 1){
            for(var j = 1; j < panes.length; j++) {
                panes[j].style.display = 'none';
            }
        }

        var links = tab.querySelectorAll('.c-tabs-nav a');

        for(var a = 0; a < links.length; a++){
            links[a].addEventListener('click', function(event){
                var pane = event.target.attributes["data-tab"].value;

                var links = this.querySelectorAll('.js-tab-link');

                for(var a = 0; a < links.length; a++) {
                    if (links[a] == event.target){
                        links[a].classList.add('is-active');
                    } else {
                        links[a].classList.remove('is-active');
                    }
                }

                var panes = this.querySelectorAll('.js-tab');

                for(var j = 0; j < panes.length; j++) {
                    if (panes[j].id == pane){
                        panes[j].style.display = 'block';
                    } else {
                        panes[j].style.display = 'none';
                    }
                }

            }.bind(tab));
        }
    }

    var pres = document.querySelectorAll("[data-url]");

    for(var i = 0; i < pres.length; i++){
        var pre = pres[i];
        var a = document.createElement("a");
        a.href = pre.attributes['data-url'].value;
        a.innerHTML = "View the full file";
        a.setAttribute("target", "_blank");

        pre.parentNode.insertBefore(a, pre.nextSibling);
    }

    pres = document.querySelectorAll("[data-demo-url]");

    for(var i = 0; i < pres.length; i++){
        var pre = pres[i];
        var a = document.createElement("a");
        a.href = pre.attributes['data-demo-url'].value;
        a.innerHTML = "View the demo";
        a.className = "c-button c-button--small";

        pre.parentNode.insertBefore(a, pre.nextSibling);
    }

    // Webfonts
    var MTIProjectId='b00cbac7-a878-4c08-9abc-c0d909f94713';
     (function() {
            var mtiTracking = document.createElement('script');
            mtiTracking.type='text/javascript';
            mtiTracking.async='true';
             mtiTracking.src='/static/js/mtiFontTrackingCode.js';
            (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
       })();

</script>
</body>
</html><?php
    }
}