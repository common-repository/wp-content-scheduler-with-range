jQuery(document).ready(function(){

	if ( jQuery('.ced_wcswr_occasional_content').length ) {
		
		var temp_close = '<div id="ced_wcswr_templ_close_occ_content"><span>X</span></div>';
		jQuery('.ced_wcswr_occasional_content').prepend(temp_close);
	}
	jQuery(document).on('click', '#ced_wcswr_templ_close_occ_content', function() {
		jQuery(this).parents('div.ced_wcswr_occasional_content').remove();
	})
})