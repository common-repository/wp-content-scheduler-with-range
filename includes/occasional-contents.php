<?php
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}

/**
 * Displays the Occasional Content
 *
 * @author CedCommerce
 * @category function
 */
function ced_wcswr_occasional_contents_display() {
	
	// Fetches occasional content saved from backend
	$occasional_contents = get_option ( CED_WCSWR_PREFIX . '_occasional_contents' );
	if ( empty( $occasional_contents ) ) {
		return false;
	}	
	$occasional_contents = unserialize ( $occasional_contents );
	$days = array( '' , 'Monday' , 'Tuesday' , 'Wednesday' , 'Thursday' , 'Friday' , 'Saturday' , 'Sunday' );
	$months = array( '' ,  'January' , 'February' , 'March' , 'April' , 'May' , 'June' , 'July' , 'August' , 'September' , 'October' , 'November' , 'December' );
	$flag = 0 ;
	$time_to ='';
	$time_from = '';
	$current_time = current_time( 'h:i A' );

	if(isset($occasional_contents[0]) && is_array($occasional_contents[0])  && !empty($occasional_contents))
	{
		foreach ($occasional_contents as $key => $value)
		{
			$time_from = $value['occasion_time_from'];
			$time_to = $value['occasion_time_to'];
			if ( $value['display_term'] == 'date_range' ) {				
				// Fetches dates of content, from-to the content is to be shown
				$occasional_contents_date_from 	= $value['occasion_date_from'] .' '. $value['occasion_time_from'];
				$occasional_contents_date_to 	= $value['occasion_date_to'] .' '. $value['occasion_time_to'];
				// Formats the dates into object to campare timing
				$current_date_time 	=	current_time ( 'Y/m/d h:i A' );
				$renderDate 		=	DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
				$contractDateBegin 	=	DateTime::createFromFormat ( 'Y/m/d h:i A', $occasional_contents_date_from );
				$contractDateEnd 	=	DateTime::createFromFormat ( 'Y/m/d h:i A', $occasional_contents_date_to );
				// Checks for occasional content date
				if ( $renderDate >= $contractDateBegin && $renderDate <= $contractDateEnd )
				{
					$flag = 1;
				}
			}else if( $value[ 'display_term' ] == 'weekly' ){
				$days_selected = $value[ 'days_selected' ];
				$current_day = $days[date('N')];
				if( in_array( strtolower($current_day), $days_selected ) && $current_time >= $time_from && $current_time <= $time_to ){
					$flag = 1;
				}
			}else if( $value[ 'display_term' ] == 'monthly' ){
				$months_selected = $value['months_selected'];
				$current_month = $months[date('n')];
				if ( in_array( strtolower($current_month) , $months_selected ) && $current_time >= $time_from && $current_time <= $time_to ) {
					$flag = 1;
				}
			}else if( $value[ 'display_term' ] == 'daily' && $current_time >= $time_from && $current_time <= $time_to ){
				$flag = 1;
			}
			if ($flag == 1) 
			{				
				// Fetches pages for which occasional content will be applied
				$applied_for = $value['applied_for'];
				
				// Checks if occasional content is for specific page or post
				
				if ($applied_for == "All Posts") 
				{
					// Invokes function for all posts' content
					do_action ( CED_WCSWR_PREFIX . '_occasional_content_for_all_post' );
				} 
				elseif ($applied_for == 'All Pages') 
				{
					// Invokes function for all page's content
					do_action ( CED_WCSWR_PREFIX . '_occasional_content_for_all_page' );
				}
				elseif (gettype($value['applied_for']) =="array")
				{
					foreach ($value['applied_for'] as $key => $value2) 
					{
						$applied_for=$value2;
					
					// Invokes function for specific page conetent
					do_action ( CED_WCSWR_PREFIX . '_occasional_content_for_specific_page',$applied_for);
					}
				}
			} 					
		}
	}	
}
add_action ( 'wp_head', CED_WCSWR_PREFIX . '_occasional_contents_display' );

/**
 * Displays the Occasional Content for specific pages
 *
 * @param array $applied_for        	
 * @author CedCommerce
 * @category function
 */
function ced_wcswr_occasional_content_for_specific_page( $applied_for ) {

	// Fetches occasional content saved from backend
	$occasional_contents = get_option ( CED_WCSWR_PREFIX . '_occasional_contents' );
	if (empty($occasional_contents)) {
		return false;
	}
	$occasional_contents = unserialize ( $occasional_contents );
	foreach ($occasional_contents as $key => $value)
	{ 
		if (! empty ( $applied_for ) && is_array($occasional_contents[0]) && is_array($value['applied_for']))
		{
			$url = get_permalink ( $applied_for );		
			$current_url = 'http://' . $_SERVER [ "HTTP_HOST" ] . $_SERVER [ "REQUEST_URI" ];
			if ( $url == $current_url)
			{
				$post = get_post ( $applied_for );	
				if( $value[ 'content_pos' ] == 'Top' && in_array($applied_for , $value['applied_for']) )
				{ 	
					echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_top" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $value[ 'content_to_show' ] ).'</p></div>';
				} 
				else if ( $value['content_pos'] == 'Bottom' && in_array($applied_for , $value['applied_for']) )
				{
					echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_bottom" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $value[ 'content_to_show' ] ).'</p></div>';
				}
			}
		}
	}
}
add_action ( CED_WCSWR_PREFIX . '_occasional_content_for_specific_page', CED_WCSWR_PREFIX . '_occasional_content_for_specific_page', 10, 1 );

/**
 * Displays the Occasional Content for all pages
 *
 * @author CedCommerce
 * @category function
 */
function ced_wcswr_occasional_content_for_all_page() {

	// Fetches occasional content saved from backend
	$occasional_contents = get_option ( CED_WCSWR_PREFIX . '_occasional_contents' );
	if (empty($occasional_contents)) {
		return false;
	}
	$occasional_contents = unserialize ( $occasional_contents );
	
		if ($occasional_contents[0] ['content_pos'] == "Top") 
		{
				echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_top" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $occasional_contents[0][ 'content_to_show' ] ).'</p></div>';
			
		}
		else if ($occasional_contents[0] ['content_pos'] == "Bottom")
		{
			
			
			echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_bottom" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $occasional_contents[0][ 'content_to_show' ] ).'</p></div>';
			
		}
}
add_action ( CED_WCSWR_PREFIX . '_occasional_content_for_all_page', CED_WCSWR_PREFIX . '_occasional_content_for_all_page', 10 );

/**
 * Displays the Occasional Content for all post( Single page of Posts )
 *
 * @author CedCommerce
 * @category function
 */
function ced_wcswr_occasional_content_for_all_post() {

	// Fetches occasional content saved from backend
	$occasional_contents = get_option ( CED_WCSWR_PREFIX . '_occasional_contents' );
	if (empty($occasional_contents)) {
		return false;
	}
	$occasional_contents = unserialize ( $occasional_contents );

		if ( is_single () ) {
			if ($occasional_contents[0] ['content_pos'] == "Top") 
			{
				
					echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_top" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $occasional_contents[0][ 'content_to_show' ] ).'</p></div>';
				
			}
			else if ($occasional_contents[0] ['content_pos'] == "Bottom")
			{
				
				echo $content_to_show='<div id="ced_wcswr_occasional_content_wrap_bottom" class="ced_wcswr_occasional_content"><p>'.stripslashes ( $occasional_contents[0][ 'content_to_show' ] ).'</p></div>';
				
			}
		}
}
add_action ( CED_WCSWR_PREFIX . '_occasional_content_for_all_post', CED_WCSWR_PREFIX . '_occasional_content_for_all_post', 10 );
?>