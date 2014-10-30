/**
 * Author Lukáš Drahník <L.Drahnik@gmail.com>
 */

/**
 * Hide/Show user-panel-add modal
 */
/*function userPanelAdd() {
    var e = document.getElementById('user-panel-add');
    if(e.style.display == 'none') {
        e.style.display = 'block';
    } else {
        e.style.display = 'none';
    }
}*/

// aktivace odkazu na zobrazeni dialogu
/*jQuery(function($) {
    $('a.ajaxdialog').live('click', function(event) {
        event.preventDefault();
        $.post($.nette.href = this.href, function(data) {
            // (mimo jine) injektovani formulare do HTML
            $.nette.success(data);
            // aktivace ajaxoveho submitu formulare
            activateAjaxForm();
            // zobrazeni formulare v dialogu
            $("#snippet--simpleForm").dialog();
        }, "json");
    });
});*/
// aktivace "ajaxoveho" formulare
/*function activateAjaxForm () {
    $("#snippet--simpleForm form :submit").click(function () {
        $(this).ajaxSubmit();
        $("#snippet--simpleForm").dialog( "destroy" ); // po submitnuti zavreme dialog
        return false;
    });
*/

