<?php

namespace Rhubarb\Website\Layouts;

require_once VENDOR_DIR."/rhubarbphp/rhubarb/src/Layout/Layout.php";

use Rhubarb\Crown\Application;
use Rhubarb\Crown\Deployment\ResourceDeploymentPackage;
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

    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width; user-scalable=yes; initial-scale=1.0; maximum-scale=1.0;">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<!--<link href="/static/css/screen.css" rel="stylesheet" type="text/css" />-->
<link href="/static/css/main.css" rel="stylesheet" type="text/css" />
<link href="/static/css/dev.css" rel="stylesheet" type="text/css" />
<link href="/static/prism/prism.css" rel="stylesheet" type="text/css" />
<script src="/static/prism/prism.js" type="text/javascript"></script>
<script src="/static/js/rhubarb.js" type="text/javascript"></script>
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
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-28553529-10', 'auto');
    ga('send', 'pageview');

</script>
    <header id="page-header" class="c-header s-header">

        <!--<input type="checkbox" id="nav-primary-reveal" class="c-masthead__nav-toggle-check u-off-canvas">-->

        <h1 class="c-header__logo">
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

        <nav class="c-header__nav">
            <ul class="c-nav c-nav--primary">
                <li<?=(stripos($_SERVER["SCRIPT_NAME"], "/about") === 0) ? ' class="is-selected"' : '';?>><a href="/about">About</a></li>
                <li<?=(stripos($_SERVER["SCRIPT_NAME"], "/tutorial/index") === 0) ? ' class="is-selected"' : '';?>><a href="/tutorial/index">Get Started</a></li>
                <li<?=(stripos($_SERVER["SCRIPT_NAME"], "/manual") === 0) ? ' class="is-selected"' : '';?>><a href="/manual/index">Manual</a></li>
                <li<?=(stripos($_SERVER["SCRIPT_NAME"], "/contributing") === 0) ? ' class="is-selected"' : '';?>><a href="/contributing">Contributing</a></li>
            </ul>
        </nav>

        <a class="c-header__search"></a>
        <a class="c-header__nav-toggle" for="nav-primary-reveal"></a>

        <!-- Global Search Box -->
        <div class="o-box o-box--padded c-search-box u-margin-none">
            <div class="o-wrap">
                <span class="c-icon c-icon--search"></span>
                <input type="search" class="c-search-box__text c-text-field--naked" placeholder="Search" />
            </div>
        </div>

    </header>

    <?php
    if (stripos($request->urlPath, "/manual/") === 0) {

        $menu = NavigationTools::buildMenu(APPLICATION_ROOT_DIR . "/docs/manual/toc.txt");
        ?>
        <ul class="c-nav c-nav--secondary c-nav--flex-items">
            <?php
            $first = true;
            $selectedMenu = false;

            foreach($menu->children as $item) {

                $firstClass = ($first) ? " first" : "";
                $first = false;

                $url = $item->url;

                if ($item->containsUrl($request->urlPath)) {
                    $selectedMenu = $item;
                    $firstClass .= " open is-active";
                } else {
                    $firstClass .= " closed";
                }

                print '<li class="book '.$firstClass.' '.strtolower($item->name).'"><a href="'.$url.'"><img src="/static/images/'.$item->name.'-logo.svg" /></a></li>';
            }
            ?>

            <li class="book c-nav--secondary__extras"><a href="#"><span class="c-icon c-icon--dots-three-horizontal"></span></a></li>
        </ul>
        <?php
    }

    ?>

    <main class="c-main">

        <div class="o-box">

            <div class="o-wrap">

                <a href="#" class="c-contents-button c-button c-button--primary c-button--ghost c-button--small u-margin-bottom"><span class="c-icon c-icon--menu"></span> Contents</a>

                <div class="o-layout">

                    <?php

                        if (stripos($request->urlPath, "/manual/") === 0) {


                            print <<<HTML


                                 <div class="o-layout__item u-1/4@l u-1/3@m u-1@s">
                                 
                                    <div class="o-box u-padding-right">
                                        
                                        <ul class="c-nav-manual">
                                        
                                        <li class="u-beta"><span class="c-nav-manual__close c-icon c-icon--cross"></span></li>

HTML;


                                        $menu = NavigationTools::buildMenu(APPLICATION_ROOT_DIR . "/docs/manual/toc.txt");
                                        ?>
                                        <?php
                                        $first = true;
                                        $selectedMenu = false;

                                        foreach($menu->children as $item) {

                                            $firstClass = ($first) ? " first" : "";
                                            $first = false;

                                            $url = $item->url;

                                            if ($item->containsUrl($request->urlPath)) {
                                                $selectedMenu = $item;
                                                $firstClass .= " open is-active";
                                            } else {
                                                $firstClass .= " closed";
                                            }

                                            print '<li class="book '.$firstClass.' '.strtolower($item->name).'"><a href="'.$url.'"><img src="/static/images/'.$item->name.'-logo.svg" /></a></li>';
                                        }
                                        ?>

                                        <li class="book c-nav--secondary__extras"><a href="#"><span class="c-icon c-icon--dots-three-horizontal"></span></a></li>


                                    <?php

                                    if ($selectedMenu) {

                                        foreach ($selectedMenu->children as $item) {

                                            $firstClass = ($first) ? " first" : "";
                                            $first = false;

                                            $url = $item->url;

                                            if ((!$url) && isset($item->children) && (sizeof($item->children) > 0)) {
                                                //$url = $item->children[0]->url;
                                            }

                                            // Is the current url this one or one of the children? If so open the menu and children.
                                            print '<li class="chapter open' . $firstClass . '">'  . "" . $item->name . '</li>';

                                            NavigationTools::printMenu($item, 0);
                                        }
                                    }
                                    ?>

                                </ul>
                            </div>

                        <?php
                        }
                        ?>



                    </div>


                    <?php


                        if (stripos($request->urlPath, "/manual/") === 0) {

                            print <<<HTML

                                <div class="o-layout__item u-3/4@l u-2/3@m u-1@s">
                                    <div class="s-manual-content">
                                        <div class="o-box">
                                            <div class="c-article">

HTML;



                        }
                        else {

                            print<<<HTML
                            <div class="o-layout__item u-1@s">
                                <div class="s-manual-content">
                                    <div class="o-box">
                                        <div class="c-article u-pull-center">
HTML;




                        }


                    ?>






                            <?php

                            $settings = MenuSettings::singleton();
                            if ($settings->currentChapter){
                                $content = str_replace("<h1>", "<h1>"." ", $content);
                            }

                            parent::printLayout($content);
                            ?>
                            </div>

                        </div>
                    </div>

                    </div>


                </div>
            </div>
        </div>


        </main>


        <footer class="c-global-footer">
            <div class="c-band u-align-center u-milli">
            the tasty PHP framework.
            </div>
        </footer>




<script type="text/javascript">

    var ps = document.querySelectorAll('.s-manual-content p');

    if (ps.length > 0 ){
        ps[0].classList.add('c-intro-paragraph');
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
