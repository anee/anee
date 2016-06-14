/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */


/**
 * Hide/Show search-bar-filters
 */
function searchBarFilters() {
    var e = document.getElementById('search-bar-filters');
    if(e.style.display == 'none') {
        $('#' + 'search-bar-filters').slideToggle('');
        e.style.display = 'block';
    } else {
        e.style.display = 'none';
    }
}

/**
 * Hide/Show search-bar
 */
function searchBar() {
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
}

/**
 * Hide/Show user-panel
 */
function userPanel() {
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
}