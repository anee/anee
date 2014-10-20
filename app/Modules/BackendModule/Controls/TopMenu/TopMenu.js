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
    var e = document.getElementById('user-panel');
    if(e.style.display == 'none') {

        var s = document.getElementById('user-panel-ref');
        s.style.display = 'none';

        var c = document.getElementById('content');
        c.style.padding = '107px 400px 0 0';

        $('#' + 'user-panel').slideToggle('');
        e.style.display = 'block';
    } else {

        var s = document.getElementById('user-panel-ref');
        s.style.display = 'block';

        var c = document.getElementById('content');
        c.style.padding = '107px 0 0 0';

        e.style.display = 'none';
    }
}
