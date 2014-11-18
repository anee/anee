$(function () {
    $.nette.init();


    /* autosize plugin */
    Plugins.AutosizeInput.getDefaultOptions().space = 0;
    $(".autosize").autosizeInput();
});