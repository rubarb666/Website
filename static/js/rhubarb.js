var $j = jQuery.noConflict();

$j(function () {

    //Triggering menu button animation
    $j('.c-header__search').click(function () {
        $j('.c-search-box').toggleClass('is-active');
        $j('.c-header__search').toggleClass('is-active');
    });


    //Triggering menu button animation
    $j('.c-header__nav-toggle').click(function () {
        $j('.c-header__nav').toggleClass('is-active');
        $j('.c-header__nav-toggle').toggleClass('is-active');
    });

    //Triggering menu button animation
    $j('.c-contents-button').click(function () {
        $j('.c-nav-manual').toggleClass('is-active');
        $j('.c-contents-button').toggleClass('is-active');
    });

});

