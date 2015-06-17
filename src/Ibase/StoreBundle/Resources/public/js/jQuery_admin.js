 //File web\bundles\ibasestore\js\jquery_admin.js
 jQuery(document).ready(function(){
    jQuery.datepicker.setDefaults( jQuery.datepicker.regional[ "" ] );
    jQuery(".datepicker").datepicker( jQuery.datepicker.regional[ "en" ]);
    $('.sonata-ba-list-field-header').attr('class','sonata-ba-list-field-header success');
     var $table = $('table');
    $table.floatThead(
        {
            scrollingTop: 50,
            useAbsolutePositioning: true
        }
     );
});