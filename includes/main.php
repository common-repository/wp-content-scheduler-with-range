<?php
if (! defined ( 'ABSPATH' )) {
	exit (); // Exit if accessed directly
}

/**
 * Function Name: Create Date Box
 * Description: Creates Date Boxes while adding a new post
 *
 * @author CedCommerce
 */
function ced_wcswr_create_date_box() {
	global $wp_post_types;
	// Fetches current post type
	$current_post_type = get_post_type ();
	$saved_post_types = get_option ( CED_WCSWR_PREFIX . '_post_types' );
	$saved_post_types = unserialize ( $saved_post_types );
	if (! empty ( $saved_post_types ) && is_array($saved_post_types) ) {
		foreach ( $saved_post_types as $post_type ) {
			if ($current_post_type == $post_type) {
				// Creates A Date Boxes while adding a new post
				add_meta_box ( CED_WCSWR_PREFIX . '_meta_box_detail', 'Content Scheduling Dates', CED_WCSWR_PREFIX . '_date_box_definition', $post_type, 'side', '', null );
			}
		}
	}
}
add_action ( 'add_meta_boxes', CED_WCSWR_PREFIX . '_create_date_box' );

/**
 * Function Name: Date Box Definition
 * Description: Describes Date Box Definition and functionalities
 *
 * @author CedCommerce
 */
function ced_wcswr_date_box_definition() {
	global $post;
	
	// Fetches date's meta boxes value correspondig each posts
	$get_from_date = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_from_date', true );
	$get_to_date = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_date', true );
	$get_from_time = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_from_time', true );
	$get_to_time = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_time', true );
	?>
	<!-- Creating HTML of Date Box's Start -->
	<div class="postbox ced_wcswr_date_range">
		<table>
			<tr>
				<td><label for="<?php echo CED_WCSWR_PREFIX; ?>_from"><?php _e('From:', 'wp-content-scheduler-with-range')?></label></td>
				<td>
					<input type="text" size="8" id="<?php echo CED_WCSWR_PREFIX; ?>_from" class="ced_wcswr_date_pick" name="from_date" 
					readonly="readonly" value="<?php echo $get_from_date;?>" placeholder="<?php echo __( 'Select initial date' )?>">
					<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_from"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
					
					<input type="text" size="6" id="<?php echo CED_WCSWR_PREFIX; ?>_time_from" class="ced_wcswr_time_pick timepicker" 
					readonly="readonly" name="from_time" value="<?php echo $get_from_time;?>" placeholder="<?php echo __( 'Select initial time' )?>">
					<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_time_from"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span> 
					
				</td>
			</tr>
			<tr>
				<td><label for="<?php echo CED_WCSWR_PREFIX; ?>_to"><?php _e('To:', 'wp-content-scheduler-with-range')?></label></td>
				<td>
					<input type="text" size="8" id="<?php echo CED_WCSWR_PREFIX; ?>_to" class="ced_wcswr_date_pick" name="to_date" 
					readonly="readonly" value="<?php echo $get_to_date;?>" placeholder="<?php echo __( 'Select over date' )?>">
					<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_to"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
					
					<input type="text" size="6" id="<?php echo CED_WCSWR_PREFIX; ?>_time_to" class="ced_wcswr_time_pick timepicker" 
					readonly="readonly" name="to_time" value="<?php echo $get_to_time;?>" placeholder="<?php echo __( 'Select over time' )?>">
					<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_time_to"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
				</td>
			</tr>
		</table>
	</div>
	<!-- Creating HTML of Date Box's End -->
<?php
}

/**
 * Function Name: Save Detail Date Box
 * Description: Saves Date Box's value in database
 *
 * @author : CedCommerce
 */
function ced_wcswr_save_detail_date_box($post_id) {
		// Sanitize the user input.
	$from_date = isset ( $_POST ['from_date'] ) ? $_POST ['from_date'] : '';
	$to_date = isset ( $_POST ['to_date'] ) ? $_POST ['to_date'] : '';
	
	$from_time = isset ( $_POST ['from_time'] ) ? $_POST ['from_time'] : '';
	$to_time = isset ( $_POST ['to_time'] ) ? $_POST ['to_time'] : '';
	if ( !empty ( $from_time ) || !empty ( $to_time ) ) {
		if ( empty ( $from_time ) ) {
			$from_time = '12:00 AM';
		} else if ( empty ( $to_time ) ) {
			if ( !empty( $to_date ) ) {
				$to_time = '11:59 PM';
			}
		}
	}
	// Update the meta field.
	update_post_meta ( $post_id, CED_WCSWR_PREFIX . '_from_date', $from_date );
	update_post_meta ( $post_id, CED_WCSWR_PREFIX . '_to_date', $to_date );
	update_post_meta ( $post_id, CED_WCSWR_PREFIX . '_from_time', $from_time );
	update_post_meta ( $post_id, CED_WCSWR_PREFIX . '_to_time', $to_time );
}
add_action ( 'save_post', 'ced_wcswr_save_detail_date_box' );

/**
 * Function Name: My Date Query
 * Description: Filter posts according to date box's dates
 *
 * @author CedCommerce
 * @param string $where        	
 * @return string
 */
function ced_wcswr_date_query($where) {
	global $wpdb;
	
	// Initializing a variable to collect all the post id which is to be shown
	$posts_to_be_shown = array ();
	
	// Checks if not admin interface page ( Works only for Frontend )
	if (! is_admin ()) {		
		// Fetching all the published posts from database
		$all_posts = $wpdb->get_results ( "SELECT * FROM `" . $wpdb->posts . "` WHERE post_status NOT IN ( 'trash', 'draft', 'auto_draft', 'inherit', 'pending', 'private', 'future' ) " );
		
		// Appends our query
		$where .= " AND $wpdb->posts.ID IN ( ";
		
		if (! empty ( $all_posts )) {
			// Traverses all the posts
			// print_r($all_posts);
			foreach ( $all_posts as $index => $post ) {				
				
				// Fetches meta value of From date-box
				$get_from_date = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_from_date', true );
				
				// Fetches meta value of To date-box
				$get_to_date = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_date', true );
				
				// Fetches meta time of From date-box
				$get_from_time = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_from_time', true );
				
				// Fetches meta time of To date-box
				$get_to_time = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_time', true );
				
				// Checks if both the date-box fields are not empty
				if (! empty ( $get_from_date ) && ! empty ( $get_to_date ) ) {
					
					$current_date_time = current_time ( 'Y/m/d h:i A' );
					$renderDate = DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
					$contractDateBegin = DateTime::createFromFormat ( 'Y/m/d h:i A', $get_from_date . ' ' . $get_from_time );
					$contractDateEnd = DateTime::createFromFormat ( 'Y/m/d h:i A', $get_to_date . ' ' . $get_to_time );
					
					if ( $renderDate >= $contractDateBegin && $renderDate <= $contractDateEnd ) {
						$posts_to_be_shown [] = $post->ID;
					}
				} else if (! empty ( $get_from_date ) && empty ( $get_to_date ) ) {
					
					$current_date_time = current_time ( 'Y/m/d h:i A' );
					$renderDate = DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
					$contractDateBegin = DateTime::createFromFormat ( 'Y/m/d h:i A', $get_from_date .' '. $get_from_time );
					
					if ( $renderDate >= $contractDateBegin ) {
						$posts_to_be_shown [] = $post->ID;
					}
				} else if (empty ( $get_from_date ) && ! empty ( $get_to_date ) ) {
					
					$current_date_time = current_time ( 'Y/m/d h:i A' );
					$renderDate = DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
					$contractDateEnd = DateTime::createFromFormat ( 'Y/m/d h:i A', $get_to_date .' '. $get_to_time );
					
					if ( $renderDate <= $contractDateEnd ) {
						$posts_to_be_shown [] = $post->ID;
					}
				} else {
					$posts_to_be_shown [] = $post->ID;
				}
			}
			// print_r($posts_to_be_shown);
			foreach ( $posts_to_be_shown as $key => $val ) {
				$where .= " '$val'";
				
				if ( array_key_exists( ($key + 1 ), $posts_to_be_shown ) ) {
					$where .= ", ";
				}
			}
			$where .= " )";
		}
	}		
	return $where;
}
add_filter ( 'posts_where', 'ced_wcswr_date_query' );

/**
 * Functio Name: ced_wcswr Move To Trash
 * Description: Moves a post to trash after finishing the date if move to trash
 * option is checked in settings.
 *
 * @author CedCommerce
 */
function ced_wcswr_move_to_setting() {
	global $wpdb;
	
	// Fetching all the published posts from database
	$all_posts = $wpdb->get_results ( "SELECT * FROM `" . $wpdb->posts . "` WHERE `post_status` = 'publish' " );
	
	// Fetches move to trash setting
	$move_to = get_option ( CED_WCSWR_PREFIX . '_move_to' );
	//die($move_to);
	
	// Traverses all the posts
	foreach ( $all_posts as $index => $post ) {
		
		// Fetches meta value of To date-box
		$get_to_date = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_date', true );
		
		
		// Fetches meta time of To date-box
		$get_to_time = get_post_meta ( $post->ID, CED_WCSWR_PREFIX . '_to_time', true );
		
		// Checks for end date of the post
		if ( $get_to_date && $get_to_time ) {
			
			// Fetches today's date
			$current_date_time = current_time ( 'Y/m/d h:i A' );
			
			// Creates format of today's date
			$renderDate = DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
			
			// Creates format of post's end date
			$contractDateEnd = DateTime::createFromFormat ( 'Y/m/d h:i A', $get_to_date .' '. $get_to_time );
			
			if ($renderDate > $contractDateEnd) {
				if ( $move_to == "Trash" ) {
					wp_trash_post ( $post->ID );
				}

				else if ( $move_to == "Draft" ) {
					$draft_post = array(
					      'ID' => $post->ID,
					      'post_status' => 'draft'
					  );
					wp_update_post($draft_post);
				}
				else {
					$nothing = array(
						'ID' => $post->ID,
						'post_status' => 'publish'
						);
					wp_update_post($nothing);
				}
			}
		}
	}
}
add_action ( 'admin_init', CED_WCSWR_PREFIX . '_move_to_setting' );
?>