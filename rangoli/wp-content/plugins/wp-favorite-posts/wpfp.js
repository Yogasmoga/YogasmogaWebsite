var AjaxRun = false;
jQuery(document).ready( function(jQuery) {
    jQuery('body').on('click', '.wpfp-link', function() {
		
		if(AjaxRun) return false;
		
		AjaxRun = true;
        dhis = jQuery(this);
		if(dhis.hasClass('add')){
			dhis.addClass('remove');
		}else{
			dhis.addClass('add').removeClass('remove');
		}
        wpfp_do_js( dhis, 1 );
        // for favorite post listing page
        if (dhis.hasClass('remove-parent')) {
            dhis.parent("li").fadeOut();
        }
        return false;
    });
    jQuery('body').on('click', '.ajax-fancy', function(e) {
		e.preventDefault();
		var url = jQuery(this).attr('href');
        jQuery.fancybox({href : url}, {type: 'ajax', autoCenter:true, autoResize: true, });
		return false;
    });
});

function wpfp_do_js( dhis, doAjax ) {
    loadingImg = dhis.prev();
    loadingImg.show();
    pid = dhis.attr('rel');
    beforeImg = dhis.prev().prev();
    beforeImg.hide();
    url = document.location.href.split('#')[0];
    params = dhis.attr('href').replace('?', '') + '&ajax=1';
    if ( doAjax ) {
        jQuery.get(url, params, function(data) {
			if(data.indexOf('login') > -1) {
				jQuery.fancybox(data, {autoCenter:true});
			} else {
				jQuery('.fav-'+pid).each(function(){
					jQuery(this).parent().html(data);
				});
			}
                if(typeof wpfp_after_ajax == 'function') {
                    wpfp_after_ajax( dhis ); // use this like a wp action.
                }
                loadingImg.hide();
				AjaxRun = false;
            }
        );
    }
}
