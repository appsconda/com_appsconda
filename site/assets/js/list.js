jQuery(document).ready(function(){
    jQuery('#clear-search').click(function() {
        jQuery('#filter-search').val('');
        jQuery('#adminForm').submit();
    });
});
