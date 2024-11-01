jQuery( document ).ready( function( $ ) {
	var content_to_show='';
	/**
	 * Hide Settings tab on page load
	 */
	jQuery( '#ced_wcswr_tab_content2' ).hide();
	jQuery( '#ced_wcswr_tab_content3_1' ).hide();
	jQuery( '#ced_wcswr_tab_content3_2' ).hide();
	jQuery( '#ced_wcswr_tab_content3_3' ).hide();
	jQuery( '#ced_wcswr_tab_content3_4' ).hide();
	jQuery( '#ced_wcswr_tab_content4' ).hide();
	jQuery( '.wrap #wcswr-nav-tab-wrapper' ).hide();
	if ( jQuery( '#ced_wcswr_week' ).length > 0 ) {
		jQuery( '#ced_wcswr_week' ).select2({
			placeholder: '--Select Days--',
			allowClear: true
		});
	};
	if ( jQuery( '#ced_wcswr_month' ).length > 0 ) {
		jQuery( '#ced_wcswr_month' ).select2({
			placeholder: '--Select Months--',
			allowClear: true
		});
	}
	$( '.ced_wcswr_display_term' ).on( 'change', function(){		
		var option_selected = $(this).val();
		$('.ced_wcswr_weekly').hide();
		$('.ced_wcswr_monthly').hide();
		$('.ced_wcswr_date_range').hide();
		$('.ced_wcswr_'+option_selected).show();		
	});
	/**
	 * Show tab 1 (Post Type) on click, hides remaining
	 */
	jQuery( '#ced_wcswr_tab1' ).on( 'click', function(){
		
		jQuery( 'div.ced_wcswr_active' ).removeClass( 'ced_wcswr_active' );
		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery( this ).addClass( 'ced_wcswr_active' );
		jQuery('#ced_wcswr_tab_content1').show();
		jQuery('#ced_wcswr_tab_content2').hide();
		jQuery('#ced_wcswr_tab_content3_1').hide();
		jQuery( '#ced_wcswr_tab_content3_2' ).hide();
		jQuery( '#ced_wcswr_tab_content3_3' ).hide();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery( '#ced_wcswr_tab_content4' ).hide();
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).hide();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');

	});
	
	/**
	 * Show tab 2 (Move to trash) on click, hides remaining
	 */
	jQuery('#ced_wcswr_tab2').on('click', function(){
		
		jQuery( 'div.ced_wcswr_active' ).removeClass('ced_wcswr_active');
		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery(this).addClass('ced_wcswr_active');
		jQuery('#ced_wcswr_tab_content1').hide();
		jQuery('#ced_wcswr_tab_content2').show();
		jQuery('#ced_wcswr_tab_content3_1').hide();
		jQuery( '#ced_wcswr_tab_content3_2' ).hide();
		jQuery( '#ced_wcswr_tab_content3_3' ).hide();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery( '#ced_wcswr_tab_content4' ).hide();
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).hide();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');
	});
	
	/**
	 * Show tab 3 (occasional Content) on click, hides remaining
	 */
	jQuery('#ced_wcswr_tab3').on('click', function(){ 
		
		jQuery( 'div.ced_wcswr_active' ).removeClass('ced_wcswr_active');
		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery(this).addClass('ced_wcswr_active');
		jQuery( '#nav-tab1' ).addClass('ced_wcswr_active_nav_tab');
		jQuery('#ced_wcswr_tab_content1').hide();
		jQuery('#ced_wcswr_tab_content2').hide();
		jQuery('#ced_wcswr_tab_content3_2').hide();
		jQuery('#ced_wcswr_tab_content3_1').show();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery( '#ced_wcswr_tab_content4' ).hide();
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).show();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');
	});

	/**
	 * Show tab3 nav_tab1 on click, hides remaining
	 */
	jQuery( '#nav-tab1' ).on( 'click', function(){
		
		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery(this).addClass('ced_wcswr_active_nav_tab');
		jQuery('#ced_wcswr_tab_content1').hide();
		jQuery('#ced_wcswr_tab_content2').hide();
		jQuery('#ced_wcswr_tab_content3_1').show();
		jQuery( '#ced_wcswr_tab_content3_2' ).hide();
		jQuery( '#ced_wcswr_tab_content3_3' ).hide();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).show();

	});

	/**
	 * Show tab3 nav_tab2 on click, hides remaining
	 */
	jQuery( '#nav-tab2' ).on( 'click', function(){

		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery(this).addClass('ced_wcswr_active_nav_tab');
		jQuery('#ced_wcswr_tab_content1').hide();
		jQuery('#ced_wcswr_tab_content2').hide();
		jQuery( '#ced_wcswr_tab_content3_1' ).hide();
		jQuery('#ced_wcswr_tab_content3_2').show();
		jQuery( '#ced_wcswr_tab_content3_3' ).hide();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).show();

	});

	/**
	 * Show tab 4 (Shortcode) on click, hides remaining
	 */
	jQuery('#ced_wcswr_tab4').on('click', function(){
		
		jQuery( 'div.ced_wcswr_active' ).removeClass('ced_wcswr_active');
		jQuery( 'div.ced_wcswr_active_nav_tab' ).removeClass('ced_wcswr_active_nav_tab');
		jQuery(this).addClass('ced_wcswr_active');
		jQuery('#ced_wcswr_tab_content1').hide();
		jQuery('#ced_wcswr_tab_content2').hide();
		jQuery( '#ced_wcswr_tab_content3_1' ).hide();
		jQuery('#ced_wcswr_tab_content3_2').hide();
		jQuery('#ced_wcswr_tab_content3_3').hide();
		jQuery( '#ced_wcswr_tab_content3_4' ).hide();
		jQuery('#ced_wcswr_tab_content4').show();
		jQuery( '#applied_options option[value="Select"]').attr('selected','selected');
		jQuery( '.wrap #wcswr-nav-tab-wrapper' ).hide();
	});

	jQuery('#ced_wcswr_post').hide();
	jQuery('#ced_wcswr_page').hide();
	
	/**
	 * Applying datepicker to date box's
	 */
	var dates = jQuery( '.ced_wcswr_date_pick' ).datepicker({
		defaultDate: '',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		numberOfMonths: 1,
		showButtonPanel: true,
		onSelect: function( selectedDate ) {
			var option   = jQuery( this ).is( '#ced_wcswr_from' ) ? 'minDate' : 'maxDate';
			var instance = jQuery( this ).data( 'datepicker' );
			var date     = jQuery.datepicker.parseDate( instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			dates.not( this ).datepicker( 'option', option, date );
		}
	});
	
	/**
	 * Apply Date-Picker for occasional content
	 */
	var oDates = jQuery( '.ced_wcswr_occasion_date_pic' ).datepicker({
		defaultDate: '',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		numberOfMonths: 1,
		showButtonPanel: true,
		onSelect: function( selectedDate ) {
			var option   = jQuery( this ).is( '#ced_wcswr_occasional_from' ) ? 'minDate' : 'maxDate';
			var instance = jQuery( this ).data( 'datepicker' );
			var date     = jQuery.datepicker.parseDate( instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			oDates.not( this ).datepicker( 'option', option, date );
				
		}
	});

	/**
	 * Apply Date-Picker for edit occasional content
	 */
	var eoDates = jQuery( '.ced_wcswr_edit_occasion_date_pic' ).datepicker({
		defaultDate: '',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		numberOfMonths: 1,
		showButtonPanel: true,
		onSelect: function( selectedDate ) {
			var option   = jQuery( this ).is( '#ced_wcswr_edit_occasional_from' ) ? 'minDate' : 'maxDate';
			var instance = jQuery( this ).data( 'datepicker' );
			var date     = jQuery.datepicker.parseDate( instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			eoDates.not( this ).datepicker( 'option', option, date );
				
		}
	});

	/**
	 * Apply Date-Picker for shortcode content
	 */
	var sdates = jQuery( '.ced_wcswr_shortcode_date_pic' ).datepicker({
		defaultDate: '',
		dateFormat: 'yy/mm/dd',
		minDate: new Date(),
		numberOfMonths: 1,
		showButtonPanel: true,
		onSelect: function( selectedDate ) {
			var option   = jQuery( this ).is( '#ced_wcswr_shortcode_from' ) ? 'minDate' : 'maxDate';
			var instance = jQuery( this ).data( 'datepicker' );
			var date     = jQuery.datepicker.parseDate( instance.settings.dateFormat || jQuery.datepicker._defaults.dateFormat, selectedDate, instance.settings );
			sdates.not( this ).datepicker( 'option', option, date );
				
		}
	});

	jQuery( '.timepicker' ).timepicker({
		showPeriod: true,
	    showLeadingZero: true
    });
	
	jQuery( '.ced_wcswr_clear' ).on( 'click', function(){
		var clearInputId = jQuery( this ).attr( 'data-for' );
		jQuery( '#'+clearInputId ).val( '' );
	}); 
	
	if ( $( '#select_post_type' ).length > 0 ) {
		jQuery('#select_post_type').select2({
			 placeholder: "Select post types",
			 allowClear: false
		});
	}
	if ( $( '#select_post_type_occasional' ).length > 0 ) {
		jQuery('#select_post_type_occasional').select2({
			 placeholder: "Select post types",
			 allowClear: false
		});
	}
	if ( $( '#post_ids' ).length > 0 ) {
		jQuery('#post_ids').select2({
			 placeholder: "Select Posts",
			 allowClear: false
		});
	}
	if ( $( '#page_ids' ).length > 0 ) {
		jQuery('#page_ids').select2({
			 placeholder: "Select Pages",
			 allowClear: false
		});
	}
	if ( $( '#page_ids' ).length > 0 ) {
		jQuery('#edit_page_ids').select2({
			 placeholder: "Select Pages",
			 allowClear: false
		});
	}

	jQuery(document).on('click', '#ced_wcswr_save_settings', function(){
		
		var selected = jQuery('#select_post_type').val();
		var html = '';
		var counter = 1;
		if ( selected == '' || selected == null ){
			jQuery('.is-dismissible').remove();
			jQuery('<div class="error notice is-dismissible"><p>'+ global_var.empty_post_type_text +'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
			jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type1")});
		}else {
			jQuery('.is-dismissible').remove();
			jQuery(this).hide();
			jQuery('.ced_wcswr_post_type_loding_img').show();
			jQuery.post(
			    global_var.ajaxurl,
			    {
			        'action'			:	'save_post_type',
			        'selected'			:	selected,
			        'security_check'	:	global_var.ced_wcswr_nonce
			    },
			    function( data ) {
			    	jQuery('.ced_wcswr_post_type_loding_img').hide();
			    	jQuery('#ced_wcswr_save_settings').show();
			    	jQuery( data ).insertBefore( ".ced_wcswr_container" );
			    	var values = jQuery('#select_post_type').siblings('span').find('li.select2-selection__choice').text();
		    		values = values.replace("×"," ");
		    		values = jQuery.trim(values);
		    		values = values.split("×");
		    		jQuery('.selected_post_types').children('.ced_wcswr-occasional-content-right_wrapper').find('span').text(values);
			    }
			);
		}
	});

	/**
	* Applied for save setting
	*/
	jQuery(document).on('click', '#ced_wcswr_applied_for_save_settings', function(){

		var applied_for = jQuery( '#applied_options' ).val();
		var selected='';
		if( applied_for == 'Specific Pages' ) {
			selected = jQuery('#page_ids').val();
		}
		if( applied_for == 'All Pages' ){
			selected = applied_for;
		}
		if( applied_for == 'All Posts' ){
			selected = applied_for;

		}else {
			jQuery(this).hide();
			jQuery('.ced_wcswr_post_type_loding_img').show();
			jQuery.post(
			    global_var.ajaxurl,
			    {
			        'action'			:	'save_occasional_post_type',
			        'selected'			:	selected,
			        'security_check'	:	global_var.ced_wcswr_nonce
			    },
			    function( data ) {
			    	jQuery('.ced_wcswr_post_type_loding_img').hide();
			    	jQuery('#ced_wcswr_applied_for_save_settings').show();
			    	jQuery( data ).insertBefore( ".ced_wcswr_container" );
			    	var values = jQuery('#select_post_type').siblings('span').find('li.select2-selection__choice').text();
		    		values = values.replace("×"," ");
		    		values = jQuery.trim(values);
		    		values = values.split("×");
		    		jQuery('.selected_post_types').children('.ced_wcswr-occasional-content-right_wrapper').find('span').text(values);
			    }
			);
		}
	});
	
	/**
	* Move to setting
	*/
	jQuery("#ced_wcswr_move_to").on('click', function(){
		
		jQuery(this).hide();
		var move_to= jQuery('#move_to_options').val();
		jQuery('.ced_wcswr_move_to_loding_img').show();
		jQuery.post(
		    global_var.ajaxurl,
		    {
		        'action'			:	'move_to',
		        'mtt_checked'		:	move_to,
		        'security_check'	:	global_var.ced_wcswr_nonce
		    },
		    function(data){
		    	jQuery('.ced_wcswr_move_to_loding_img').hide();
		    	jQuery('#ced_wcswr_move_to').show();
		    	jQuery( '#ced_wcswr_messages' ).html( data );
		    }
		);
	});
	
	/**
	 * Select applied for
	 */
	jQuery(document).on('change', '#applied_options', function(){
		if (global_var.have_specific_pages && jQuery(this).val() != 'Specific Pages') 
		{
			if ( confirm('Your Saved Occasional events will be deleted.') ) 
			{
				jQuery('#ced_wcswr_post').hide();
				jQuery('#ced_wcswr_page').hide();
				jQuery('.ced_wcswr_applied_for').hide();
				$('.ced_wcswr_weekly').hide();
				$('.ced_wcswr_monthly').hide();
				$('.ced_wcswr_date_range').hide();
				$( '.ced_wcswr_display_term' ).val('');
				$( '#ced_wcswr_week' ).val('');
				$( '#ced_wcswr_month' ).val('');
				$( '#ced_wcswr_week' ).select2();
				$( '#ced_wcswr_month' ).select2();			
				$( 'ced_wcswr_date_range' ).val('');
				$('#ced_wcswr_occasional_from').val('');
				$('#ced_wcswr_occasional_to').val('');
				$('#ced_wcswr_occasional_time_from').val('');
				$('#ced_wcswr_occasional_time_to').val('');
				$('#ced_wcswr_occasional_content_ifr').val('');
				jQuery('#ced_wcswr_selected_specific_pages').hide();
				jQuery('#ced_wcswr_tab_content3_3').hide();
				if ( jQuery(this).val() == 'Specific Pages' ) 
				{			
					jQuery('#ced_wcswr_page').show();
					jQuery('.ced_wcswr_applied_for').show();			
					jQuery('#ced_wcswr_selected_specific_pages').show();
					jQuery('#ced_wcswr_tab_content3_3').show();
				}
				else if( jQuery(this).val() == 'All Pages' || jQuery(this).val() == 'All Posts') 
				{			
					jQuery('#ced_wcswr_tab_content3_3').show();		
				}
			}
		}else{
			jQuery('#ced_wcswr_post').hide();
			jQuery('#ced_wcswr_page').hide();
			jQuery('.ced_wcswr_applied_for').hide();
			$('.ced_wcswr_weekly').hide();
			$('.ced_wcswr_monthly').hide();
			$('.ced_wcswr_date_range').hide();
			$( '.ced_wcswr_display_term' ).val('');
			$( '#ced_wcswr_week' ).val('');
			$( '#ced_wcswr_month' ).val('');
			$( '#ced_wcswr_week' ).select2();
			$( '#ced_wcswr_month' ).select2();			
			$( 'ced_wcswr_date_range' ).val('');
			$('#ced_wcswr_occasional_from').val('');
			$('#ced_wcswr_occasional_to').val('');
			$('#ced_wcswr_occasional_time_from').val('');
			$('#ced_wcswr_occasional_time_to').val('');
			$('#ced_wcswr_occasional_content_ifr').val('');
			jQuery('#ced_wcswr_selected_specific_pages').hide();
			jQuery('#ced_wcswr_tab_content3_3').hide();
			if ( jQuery(this).val() == 'Specific Pages' ) 
			{			
				jQuery('#ced_wcswr_page').show();
				jQuery('.ced_wcswr_applied_for').show();			
				jQuery('#ced_wcswr_selected_specific_pages').show();
				jQuery('#ced_wcswr_tab_content3_3').show();
			}
			else if( jQuery(this).val() == 'All Pages' || jQuery(this).val() == 'All Posts') 
			{			
				jQuery('#ced_wcswr_tab_content3_3').show();		
			}
		}				
	});
	
	if (jQuery('#applied_options').val() == 'Specific Pages' ) {
		jQuery('#ced_wcswr_page').show();
	}
	
	/**
	* Save Occasional content settings
	*/	
	jQuery(document.body).on( 'click',"#ced_wcswr_save_occasional_content", function(){
		
		var key_id = jQuery(this).attr('data-key_id');
		var applied_for = jQuery( '#applied_options' ).val();
		var page_id = '';
		
		if( applied_for == 'Specific Pages' ) {
			page_id = jQuery('#page_ids').val();
		}
		var edit_page_ids = $( this ).attr('data-page_arr');
		var content_pos = jQuery( '#ced_wcswr_content_pos' ).val();	
		var content_to_show = get_tinymce_occasional_content().trim();

		var display_term = jQuery( '.ced_wcswr_display_term' ).val();
		var months_selected = jQuery( '#ced_wcswr_month' ).val();
		var days_selected = jQuery( '#ced_wcswr_week' ).val();

		var occasion_date_from = jQuery('#ced_wcswr_occasional_from').val();
		var occasion_date_to = jQuery('#ced_wcswr_occasional_to').val();
		var occasion_time_from = jQuery('#ced_wcswr_occasional_time_from').val();
		var occasion_time_to = jQuery('#ced_wcswr_occasional_time_to').val();		
		if (content_to_show=='' || content_pos=='' || page_id==null || occasion_time_from=='' || occasion_time_to=='' || display_term == '')
		{
			jQuery('.is-dismissible').remove();
			jQuery('<div class="error notice is-dismissible"><p>'+ global_var.empty +'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
			jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type1")});
			
		}
		
		if ( content_to_show && content_pos && display_term != '' && applied_for!='Select' && page_id!=null && occasion_time_from && occasion_time_to)
		{	
			//create date format
			var timeStartHour = new Date("01/01/2000 " + occasion_time_from).getHours();
			var timeEndHour = new Date("01/01/2000 " + occasion_time_to).getHours();          
			var timeStartMin = new Date("01/01/2000 " + occasion_time_from).getMinutes();
			var timeEndMin = new Date("01/01/2000 " + occasion_time_to).getMinutes();
			var timeStart = timeStartHour+'.'+timeStartMin;
			var timeEnd = timeEndHour+'.'+timeEndMin;

			var hourDiff = timeEnd - timeStart ;
			if(hourDiff > 0 || occasion_date_to > occasion_date_from)
			{
				jQuery('.is-dismissible').remove();
				jQuery(this).hide();
				jQuery('.ced_wcswr_occasional_content_loding_img').show();
				
				jQuery.post(
					global_var.ajaxurl,
				    {
				        'action'			:	'occasional_content',
				        'content_to_show'	:	content_to_show,
				        'occasion_date_from':	occasion_date_from,
				        'occasion_date_to'	:	occasion_date_to,
				        'occasion_time_from':	occasion_time_from,
				        'occasion_time_to'	:	occasion_time_to,
				        'applied_for'		:	applied_for,
				        'page_id'			:	page_id,
				        'edit_page_ids'		:   edit_page_ids,
				        'content_pos'		:	content_pos,
				        'display_term'		: 	display_term,
				        'months_selected'	: 	months_selected,
				        'days_selected' 	:   days_selected,
				        'key_id'			:   key_id,
				        'security_check'	:	global_var.ced_wcswr_nonce
				    },
				    function(result){
				    	jQuery('.ced_wcswr_occasional_content_loding_img').hide();
				    	window.location.href=window.location.pathname+'?page=wp-content-scheduler-with-range';
				    }
				);
			}
			else
			{
				jQuery('.is-dismissible').remove();
				jQuery('<div class="error notice is-dismissible"><p>'+ global_var.wrong_time +'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
				jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type1")});
			}
		}
	});

	/**
	* Delete occasional content
	*/
	jQuery(document.body).on('click','#ced_wcswr_delete_content', function(){
		var $this = jQuery( this );
		var key_id=jQuery(this).parents('td.title').attr('data-id');
		var delete_page=jQuery(this).parents('td.title').siblings('td.applied-for').attr('data-page_id');
		delete_page_arr=delete_page.split(',');
		jQuery.post(
				global_var.ajaxurl,
			    {
			        'action' 	 	: 'delete_occasional',
			        'key_id' 	 	:  key_id,
			        'delete_page'	:  delete_page_arr,
			        'security_check':  global_var.ced_wcswr_nonce
			    },
			    function(result){
			    	if(result==1)
			    	{
			    		$this.parents( 'tr' ).remove();
			    	}
			    	if(result==2 || result == 3)
			    	{
			    		$this.parents('#occasional_contents_table').remove();
			    		var html='<p id="no_content">No Content To Show. Add Some Occassional Content First.</p>';
			    		jQuery('#ced_wcswr_tab_content3_2').append(html);
			    	}

			    	
			    }
			);
	});

	/**
	* shows Edit occasional content
	*/
	jQuery(document.body).on('click','#ced_wcswr_edit_content', function(){

		var key_id=jQuery(this).parents('td.title').attr('data-id');
		content_to_show=jQuery(this).parents('td.title').find('#wcswr_hide').html();
		var edit_page=jQuery(this).attr( 'data-page_id' );
		var edit_page_name=jQuery(this).attr( 'data-page_name' );
		var check=typeof(edit_page);
		if(check==='number')
		{
			edit_page=edit_page.toString();
		}
		var edit_page_arr=edit_page.split(',');
		var edit_page_name_arr=edit_page_name.split(',');
		
		jQuery('#page_ids option').each(function(){

			if(jQuery(this).attr('data-unique')==='unique')
			{	
				jQuery(this).remove();
			}
		});

		var key;
		for( key in edit_page_arr )
		{
			jQuery( '#page_ids' ).append( '<option data-unique="unique" selected value="'+ edit_page_arr[key] +'">'+ edit_page_name_arr[key] +'</option>' );
			jQuery('#page_ids option[value="'+edit_page_arr[key]+'"]').attr("selected","selected");
		}
		var content_pos=jQuery(this).parents('td.title').siblings('td.content-position').text();
		
		$("#ced_wcswr_content_pos option[value='"+content_pos.trim()+"']").prop('selected', true);
		var render_date_from=jQuery(this).parents('td.title').siblings('td.rendering-date').find('p#date_from').text();
		var render_date_to=jQuery(this).parents('td.title').siblings('td.rendering-date').find('p#date_to').text();
		var render_time_from=jQuery(this).parents('td.title').siblings('td.rendering-time').find('p#time_from').text();
		var render_time_to=jQuery(this).parents('td.title').siblings('td.rendering-time').find('p#time_to').text();
		var display_term = $( this ).data( 'display' );
		$( '.ced_wcswr_display_term' ).val(display_term);
		if ( display_term == 'monthly' ) 
		{
			var months = $( this ).data( 'months' );
			$( '.ced_wcswr_weekly' ).hide();
			$( '.ced_wcswr_monthly' ).show();
			$( '.ced_wcswr_date_range' ).hide();
			$.each(months, function(i,e){
			    $("#ced_wcswr_month option[value='" + e + "']").prop("selected", true);
			});
		    $('#ced_wcswr_month').select2();
		}
		else if ( display_term == 'weekly' )
		{ 
			var days = $( this ).data( 'days' );
			$('.ced_wcswr_weekly').show();
			$('.ced_wcswr_monthly').hide();
			$('.ced_wcswr_date_range').hide();			
			
			$.each(days, function(i,e){
			    $("#ced_wcswr_week option[value='" + e + "']").prop("selected", true);			    
			});
	    	$('#ced_wcswr_week').select2();
		}
		else if ( display_term == 'date_range' ) 
		{
			var render_date_from = $( this ).data( 'from' );
			var render_date_to = $(this).data( 'to' );			
			$('.ced_wcswr_weekly').hide();
			$('.ced_wcswr_monthly').hide();
			$('.ced_wcswr_date_range').show();
			jQuery('#ced_wcswr_occasional_from').val(render_date_from);
			jQuery('#ced_wcswr_occasional_to').val(render_date_to);
		}
		jQuery('#ced_wcswr_occasional_time_from').val(render_time_from);
		jQuery('#ced_wcswr_occasional_time_to').val(render_time_to);
		set_tinymce_edit_occasional_content();
		jQuery(document.body).find('#ced_wcswr_save_occasional_content').attr('data-key_id',key_id);
		jQuery(document.body).find('#ced_wcswr_save_occasional_content').attr('data-page_arr',edit_page_arr);
		// jQuery(document.body).find('#ced_wcswr_save_occasional_content').attr('data-page_id',edit_page);

		if (edit_page_name == 'All Pages') {
			jQuery('#applied_options').val("All Pages");
		}else if(edit_page_name == 'All Posts'){
			jQuery('#applied_options').val("All Posts");
		}else{
			jQuery('#applied_options').val("Specific Pages");
		}

		jQuery('#ced_wcswr_page').show();
		
		if ( $( '#page_ids' ).length > 0 ) {
			jQuery('#page_ids').select2({
				 placeholder: "Select Pages",
				 allowClear: false
			});
		}
			
		if (edit_page_name == 'All Pages' || edit_page_name == 'All Posts') 
		{
			jQuery('.ced_wcswr_applied_for').hide();
		}
		else{
			jQuery('.ced_wcswr_applied_for').show();
		}
		jQuery('#ced_wcswr_page').show();
		jQuery('#ced_wcswr_tab_content3_1').show();
		jQuery('#ced_wcswr_tab_content3_2').hide();
		jQuery('#ced_wcswr_tab_content3_3').show();
	});


	/**
	* Delete occasional content for all posts/pages
	*/
	jQuery(document.body).on('click','#ced_wcswr_delete_all_content', function(){
		var $this = jQuery( this );
		var key_id=jQuery(this).parents('td.title').attr('data-id');
		
		jQuery.post(
				global_var.ajaxurl,
			    {
			        'action' 	 	: 'delete_occasional',
			        'key_id' 	 	:  key_id,
			        'security_check':  global_var.ced_wcswr_nonce
			    },
			    function(result){
			    	if(result==3)
			    	{
			    		var html='<p id="no_content">No Content To Show. Add Some Occassional Content First.</p>';
			    		jQuery('#ced_wcswr_tab_content3_2').append(html);
			    		$this.parents('#occasional_contents_table').remove();
			    		
			    	}
			    }
			);
	});

	/**
	* Save Shortcode content settings
	*/
	$('#ced_wcswr_create_shortcode_editor').on('keydown', function(e){
    	if ( e.keyCode == 32 || e.keyCode == 13 ) 
    	{
    		return false;
    	}
	});

	jQuery(document.body).on( 'click',"#ced_wcswr_save_shortcode_content", function(){
		
		var	shortcode = jQuery( '#ced_wcswr_create_shortcode_editor' ).val();
		var content_to_show = get_tinymce_shortcode_content().trim();
		var shortcode_date_from = jQuery('#ced_wcswr_shortcode_from').val();
		var shortcode_date_to = jQuery('#ced_wcswr_shortcode_to').val();
		var shortcode_time_from = jQuery('#ced_wcswr_shortcode_time_from').val();
		var shortcode_time_to = jQuery('#ced_wcswr_shortcode_time_to').val();
		if(shortcode=='' || content_to_show=='' || shortcode_date_from=='' || shortcode_date_to=='' || shortcode_time_from=='' || shortcode_time_to=='' )
		{
			jQuery('.is-dismissible').remove();
			jQuery('<div class="error notice is-dismissible"><p>'+ global_var.empty +'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
			jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type4")});
	        setTimeout( function(){ jQuery( '.is-dismissible' ).hide(); }, 5000 );
		}
		if ( shortcode && content_to_show && shortcode_date_from  && shortcode_date_to && shortcode_time_from && shortcode_time_to ) 
		{
			var pattern = /^[a-zA-Z0-9-_ ]*$/;
			//create date format
			if ( pattern.test(shortcode) == true ) 
			{	    		
				var timeStartHour = new Date("01/01/2000 " + shortcode_time_from).getHours();
				var timeEndHour = new Date("01/01/2000 " + shortcode_time_to).getHours();          
				var timeStartMin = new Date("01/01/2000 " + shortcode_time_from).getMinutes();
				var timeEndMin = new Date("01/01/2000 " + shortcode_time_to).getMinutes();
				var timeStart = timeStartHour+'.'+timeStartMin;
				var timeEnd = timeEndHour+'.'+timeEndMin;

				var hourDiff = timeEnd - timeStart ;
				if(hourDiff > 0 || shortcode_date_to > shortcode_date_from)
				{
					jQuery('.ced_wcswr-shortcode-content-right_wrapper2').remove();
					jQuery('<div class="ced_wcswr-shortcode-content-right_wrapper2"><code>['+ shortcode +']</code></div>').insertAfter('.ced_wcswr-shortcode-content-right_wrapper1');
					jQuery( '#ced_wcswr_create_shortcode_editor' ).val(shortcode);
					jQuery('.is-dismissible').remove();
					jQuery(this).hide();
					jQuery('.ced_wcswr_shortcode_loding_img').show();
					jQuery.post(
						global_var.ajaxurl,
					    {
					        'action'				:	'shortcode_content',
					        'shortcode'				: 	shortcode,
					        'content_to_show'		:	content_to_show,
					        'shortcode_date_from'	:	shortcode_date_from,
					        'shortcode_date_to'		:	shortcode_date_to,
					        'shortcode_time_from'	:	shortcode_time_from,
					        'shortcode_time_to'		:	shortcode_time_to,
					        'security_check'		:	global_var.ced_wcswr_nonce
					    },
					    function(result){
					    	jQuery('.ced_wcswr_shortcode_loding_img').hide();
					    	jQuery('#ced_wcswr_save_shortcode_content').show();
					    	if ( result.indexOf('success') >= 0 ) {
						        jQuery( '#ced_wcswr_messages' ).html( result );
						        jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type4")});
						        setTimeout( function(){ jQuery( '#ced_wcswr_messages' ).hide(); }, 5000 );
					    	} else {
					    		jQuery( '#ced_wcswr_messages' ).html( result );
					    		jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type4")});
						        setTimeout( function(){ jQuery( '.is-dismissible' ).hide(); }, 5000 );
					    	}
					    }
					);
				}
				else
				{
					jQuery('.is-dismissible').remove();
					jQuery('<div class="error notice is-dismissible"><p>'+ global_var.wrong_time +'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
					jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type4")});
			        setTimeout( function(){ jQuery( '.is-dismissible' ).hide(); }, 5000 );
				}
			}
			else{
				jQuery('.is-dismissible').remove();
				jQuery('<div class="error notice is-dismissible"><p>Invalid Shortcode!!!</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>').insertBefore('.ced_wcswr_setting_wrapper');
				jQuery('html,body').animate({scrollTop: jQuery(".ced_wcswr_select_post_type4")});
		        setTimeout( function(){ jQuery( '.is-dismissible' ).hide(); }, 5000 );
			}
		}
	});

	function get_tinymce_shortcode_content() {
	    if ( jQuery( "#wp-ced_wcswr_shortcode_content-wrap" ).hasClass( "tmce-active" ) ) {
	        return tinymce.get('ced_wcswr_shortcode_content').getContent();
	    } else {
	        return jQuery( '#ced_wcswr_shortcode_content' ).val();
	    }
	}

	function get_tinymce_occasional_content() {
	    if ( jQuery( "#wp-ced_wcswr_occasional_content-wrap" ).hasClass( "tmce-active" ) ) {
	        return tinymce.get('ced_wcswr_occasional_content').getContent();
	    } else {
	        return jQuery( '#ced_wcswr_occasional_content' ).val();
	    }
	}

	function get_tinymce_edit_occasional_content() {
	    if ( jQuery( "#wp-ced_wcswr_edit_occasional_content-wrap" ).hasClass( "tmce-active" ) ) {
	        return tinymce.get('ced_wcswr_edit_occasional_content').getContent();
	    } else {
	    	console.log( 'else' );
	        return jQuery( '#ced_wcswr_edit_occasional_content' ).val();
	    }
	}

	function set_tinymce_edit_occasional_content() {
	    if ( jQuery( "#wp-ced_wcswr_occasional_content-wrap" ).hasClass( "tmce-active" ) ) {
	        return tinyMCE.get('ced_wcswr_occasional_content').setContent(content_to_show);
	    } else {
	        return jQuery( '#ced_wcswr_occasional_content' ).val(content_to_show);
	    }
	}

	jQuery( document ).on( 'click', '.notice-dismiss', function() {
		jQuery( this ).parent( 'div' ).remove();
	});
	
	$( '#wcswr-post-search-input' ).on( 'keyup', function() {
		var $this = $( this ),
		val = $this.val();

		if ( val == '' ) {
			$( '.wcswr-scheduled-post' ).show();
			return false;
		}

		val = val.toLowerCase();
		$( 'tr.wcswr-scheduled-post[data-title*="'+ val +'"]' ) .show();
		$( 'tr.wcswr-scheduled-post' ).not( '[data-title*="'+ val +'"]' ).hide();
	});

});