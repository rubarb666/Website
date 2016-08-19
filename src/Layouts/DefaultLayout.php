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
        ?>

<html>

<title>Rhubarb PHP</title>

<head>

<!--<link href="/static/css/screen.css" rel="stylesheet" type="text/css" />-->
<link href="/static/css/main.css" rel="stylesheet" type="text/css" />
<link href="/static/css/dev.css" rel="stylesheet" type="text/css" />
<link href="/static/prism/prism.css" rel="stylesheet" type="text/css" />
<script src="/static/prism/prism.js" type="text/javascript"></script>
<!--<link href="/static/css/gallery.css" rel="stylesheet" type="text/css" />-->

<!--Favicons-->
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

<?=ResourceLoader::getResourceInjectionHtml();?>
    
</head>

<?php
$request = Request::current();

?>

<body <?=(StringTools::contains($request->uri, "manual")) ? 'class="l-docs"' : '';?>>





            <header id="page-header" class="c-header s-header">
                <div class="c-masthead">

                    <!--<input type="checkbox" id="nav-primary-reveal" class="c-masthead__nav-toggle-check u-off-canvas">-->
                    <h1 class="c-masthead__logo u-margin-none">
                        <a href="/">

                            <?php

                            if (strpos($request->urlPath, "manual") !== false){
                                print "<img class=\"c-site-logo\" src=\"/static/images/rhubarb-manual-logo.svg\">";
                            }
                            else {
                                print "<img class=\"c-site-logo\" src=\"/static/images/rhubarb-logo.svg\">";
                            }

                            ?>

                        </a>
                    </h1>
                    <label class="c-masthead__nav-toggle" for="nav-primary-reveal"></label>

                    <nav class="c-masthead__nav">
                        <ul class="c-nav c-nav--primary">
                            <li><a href="/about">About</a></li>
                            <li><a href="/tutorial/index">Get Started</a></li>
                            <li class="is-selected"><a href="/manual/index">Manual</a></li>
                            <li><a href="/contributing">Contributing</a></li>
                        </ul>
                    </nav>

                </div>
            </header>

            <ul class="c-nav c-nav--secondary">
                <li><a href="/tutorial/index">Rhubarb</a></li>
                <li><a href="/tutorial/index">Leaf</a></li>
                <li class="is-selected"><a href="/manual/index">Stem</a></li>
                <li><a href="/contributing">Scaffolds</a></li>
            </ul>
    </div>
    <main class="c-main">
    <div id="content" class="c-band">
        <?php
        if (stripos($request->urlPath, "/manual/") === 0) {

            $menu = NavigationTools::buildMenu(APPLICATION_ROOT_DIR . "/docs/manual/toc.txt");
            ?>
            <div id="c-manual-books">
                <ul class="c-menu">
                    <?php
                        $first = true;
                        $selectedMenu = false;

                        foreach($menu->children as $item) {

                            $firstClass = ($first) ? " first" : "";
                            $first = false;

                            $url = $item->url;

                            if ($item->containsUrl($request->urlPath)) {
                                $selectedMenu = $item;
                                $firstClass .= " open";
                            } else {
                                $firstClass .= " closed";
                            }

                            print '<li class="book '.$firstClass.' '.strtolower($item->name).'"><a href="'.$url.'">'.$item->name.'</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
        <div class="c-manual-entries">
        <?php

        if (stripos($request->urlPath, "/manual/") === 0) {
            ?>
            <ul class="c-menu">
            <div class="o-wrap">
                <?php

                if ($selectedMenu) {

                    print '<li class="book index">' . $selectedMenu->chapter . ". " . $selectedMenu->name . '</li>';

                    foreach ($selectedMenu->children as $item) {

                        $firstClass = ($first) ? " first" : "";
                        $first = false;

                        $url = $item->url;

                        if ((!$url) && isset($item->children) && (sizeof($item->children) > 0)) {
                            //$url = $item->children[0]->url;
                        }

                        // Is the current url this one or one of the children? If so open the menu and children.
                        print '<li class="chapter open' . $firstClass . '">' . $item->chapter . ". " . $item->name . '</li>';

                        NavigationTools::printMenu($item, 0);
                    }
                }
                ?>
            </div>
            </ul>
            <?php
        }
        ?>
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

    var ps = document.querySelectorAll('.c-main-content__inner p');

    if (ps.length > 0 ){
        ps[0].classList.add('first');
    }

    var tabs = document.querySelectorAll('.js-tabs');

    for(var i = 0; i < tabs.length; i++){
        var tab = tabs[i];

        var panes = tab.querySelectorAll('.js-tab');

        for(var j = 0; j < panes.length; j++) {
            if (j == 0){
                panes[j].style.display = 'block';
            } else {
                panes[j].style.display = 'none';
            }
        }

        var links = tab.querySelectorAll('.c-tabs-nav a');

        for(var a = 0; a < links.length; a++){

            if (a == 0){
                links[a].classList.add("is-active");
            }

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

    var allPres =document.querySelectorAll("pre");
    for (var i = 0; i<allPres.length; i++)
    {
        var pre = allPres[i];
        if(pre.hasAttribute("data-url") || pre.hasAttribute("data-demo-url"))
        {
            div = document.createElement("div");
            div.className="button-bar";
            pre.parentNode.insertBefore(div, pre.nextSibling);
        }
    }

    var pres = document.querySelectorAll("[data-url]");

    for(var i = 0; i < pres.length; i++){
        var pre = pres[i];
        var a = document.createElement("a");
        a.href = pre.attributes['data-url'].value;
        var urlArray = pre.attributes['data-url'].value.split("/");
        var fileName = urlArray[urlArray.length-1];
        a.innerHTML = "View " + fileName + " on github";
        a.setAttribute("target", "_blank");
        a.className = "git-hub-link";

        pre.nextSibling.appendChild(a);
    }

    pres = document.querySelectorAll("[data-demo-url]");

    for(var i = 0; i < pres.length; i++){
        var pre = pres[i];
        var a = document.createElement("a");
        a.href = pre.attributes['data-demo-url'].value;
        a.innerHTML = "View the demo";
        a.className = "c-button c-button--small demo-button";

       pre.nextSibling.appendChild(a);
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
</html>

        <?php
    }
}
