$(function () {
    $.nette.init();
    Plugins.AutosizeInput.getDefaultOptions().space = 0;
    $(".autosize").autosizeInput();

    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-57942334-1', 'auto');
    ga('send', 'pageview');

    $(window).scroll(function () {
        var current_scroll = $(window).scrollTop();

        if (current_scroll > 35) {
            var s = document.getElementById('top');
            s.style.display = "none";

            var u = document.getElementById('under-top');
            u.style.top = "0px";

            var u = document.getElementById('user-panel-ref');
            u.style.top = "0px";

            var u = document.getElementById('right-menu');
            u.style.top = "0px";

            var u = document.getElementById('right-menu-preview');
            u.style.top = "0px";

            var u = document.getElementById('search-bar');
            u.style.top = "70px";

            var u = document.getElementById('search-bar-filters');
            u.style.top = "111px";
        } else {
            var s = document.getElementById('top');
            s.style.display = "block";

            var u = document.getElementById('under-top');
            u.style.top = "36px";

            var u = document.getElementById('user-panel-ref');
            u.style.top = "36px";

            var u = document.getElementById('right-menu');
            u.style.top = "36px";

            var u = document.getElementById('right-menu-preview');
            u.style.top = "36px";

            var u = document.getElementById('search-bar');
            u.style.top = "106px";

            var u = document.getElementById('search-bar-filters');
            u.style.top = "147px";
        }
    });
    $(window).scroll(function () {
        var current_scroll = $(window).scrollTop();

        if (current_scroll > 275) {
            var s = document.getElementById('wall-summary');
            s.style.top = "75px";
            s.style.position = "fixed";
        } else {
            var s = document.getElementById('wall-summary');
            s.style.top = "";
            s.style.position = "";
        }
    });
    $(".datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
        todayBtn: true
    });
    $("#frm-profile-addTrackModal-addTrackForm-distance").on("keyup", function () {
        avgSpeedRecalculate();
    });
    $("#frm-profile-addTrackModal-addTrackForm-timeInSeconds").on("keyup", function () {
        avgSpeedRecalculate();
    });
    function avgSpeedRecalculate() {
        var timeInSecondsInput = $("#frm-profile-addTrackModal-addTrackForm-timeInSeconds");
        var avgSpeedInput = $("#frm-profile-addTrackModal-addTrackForm-avgSpeed");
        var distanceInput = $("#frm-profile-addTrackModal-addTrackForm-distance");

        var timeInSeconds = timeInSecondsInput.val();
        if (timeInSeconds.length > 10) {
            var seconds = parseInt(timeInSeconds.substr(0, 2)) * 3600 + parseInt(timeInSeconds.substr(4, 2) * 60) + parseInt(timeInSeconds.substr(8, 2));
            if (seconds && seconds !== 'undefined') {
                var avgSpeed = ((distanceInput.val() * 1000) / seconds * 3.6).toFixed(2);

                avgSpeedInput.val(avgSpeed + ' km/h');
            } else {
                avgSpeedInput.val('0.00 km/h');
            }
        }
    }
    $(".right-menu-href").on("click", function () {
       rightMenuClicked();
    });
    function rightMenuClicked() {
        var userPanelRef = document.getElementById('user-panel-ref');
        var userPanel = document.getElementById('user-panel');
        var menuPreview = document.getElementById('right-menu-preview');
        var menu = document.getElementById('right-menu');
        var content = document.getElementById('content');

        if (userPanel.style.display == 'none') {                         // open preview
            userPanelRef.style.display = 'none';

            menuPreview.style.display = 'block';

            userPanelRef.style.display = 'none';

            content.style.padding = '107px 80px 0 0';

            $('#' + 'user-panel').slideToggle('');
            userPanel.style.display = 'block';

        } else if (menuPreview.style.display == 'block') {                // open full menu
            menuPreview.style.display = 'none';
            menu.style.display = 'block';
            content.style.padding = '107px 400px 0 0';
        } else if (menu.style.display == 'block') {                       // close it
            userPanelRef.style.display = 'block';
            menu.style.display = 'none';
            menuPreview.style.display = 'none';

            content.style.padding = '107px 0 0 0';

            userPanel.style.display = 'none';
        }
    };
    $("#search-bar-href").on("click", function () {
        var e = document.getElementById('search-bar-filters');
        e.style.display = 'none';

        var e = document.getElementById('search-bar');
        if(e.style.display == 'none') {
            $('#' + 'search-bar').slideToggle('');

            var s = document.getElementById('search');
            s.style.height = "67px";
            s.style.borderBottom = "solid 3px #adbfcd";
            s.style.backgroundColor = "white";

            e.style.display = 'block';
        } else {

            var s = document.getElementById('search');
            s.style.backgroundColor = "transparent";
            s.style.borderBottom = "none";

            e.style.display = 'none';
        }
    });
    $('#search-bar-filters-href').on("click", function() {
        var e = document.getElementById('search-bar-filters');
        if(e.style.display == 'none') {
            $('#' + 'search-bar-filters').slideToggle('');
            e.style.display = 'block';
        } else {
            e.style.display = 'none';
        }
    });
});