<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check if Class does not Exist
 */
if ( ! class_exists( 'WP_Content_Scheduler_With_Range' ) ) {

	/**
	 * Creating a class to initalize all the settings
	 * 
	 * @author CedCommerce
	 * @category class
	 */
	class WP_Content_Scheduler_With_Range {

		/**
		 * Creating Constructor of the Class
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array ( $this, CED_WCSWR_PREFIX.'_admin_enque_scripts') );
			add_action( 'wp_enqueue_scripts', array ( $this, CED_WCSWR_PREFIX.'_wp_enque_scripts') );
			add_action( 'admin_init', array ( $this, CED_WCSWR_PREFIX.'_reinit_database') );
			add_action( 'wp_ajax_save_post_type', array ( $this, CED_WCSWR_PREFIX.'_save_post_type' ) );
			add_action( 'wp_ajax_nopriv_save_post_type', array ( $this, CED_WCSWR_PREFIX.'_save_post_type' ) );
			add_action( 'wp_ajax_move_to', array ( $this, CED_WCSWR_PREFIX.'_move_to_setting' ) );
			add_action( 'wp_ajax_nopriv_move_to', array ( $this, CED_WCSWR_PREFIX.'_move_to_setting' ) );
			add_action( 'wp_ajax_occasional_content', array ( $this, CED_WCSWR_PREFIX.'_occasional_content_setting' ) );
			add_action( 'wp_ajax_nopriv_occasional_content', array ( $this, CED_WCSWR_PREFIX.'_occasional_content_setting' ) );
			add_action( 'wp_ajax_delete_occasional', array ( $this, CED_WCSWR_PREFIX.'_delete_occasional' ) );
			add_action( 'wp_ajax_nopriv_delete_occasional', array ( $this, CED_WCSWR_PREFIX.'_delete_occasional' ) );			
			add_action( 'wp_ajax_shortcode_content', array ( $this, CED_WCSWR_PREFIX.'_shortcode_content' ) );
			add_action( 'wp_ajax_nopriv_shortcode_content', array ( $this, CED_WCSWR_PREFIX.'_shortcode_content' ) );
			$shortcode = unserialize( get_option('ced_wcswr_shortcode_content') );
			if($shortcode!=null)
			{
				add_shortcode($shortcode['shortcode'] , array( $this, CED_WCSWR_PREFIX.'_create_shortcode' ) );
			}
			add_action( 'wp_ajax_filtering_posts', array ( $this, CED_WCSWR_PREFIX.'_filtering_posts' ) );
			add_action( 'wp_ajax_nopriv_filtering_posts', array ( $this, CED_WCSWR_PREFIX.'_filtering_posts' ) );
			add_filter('manage_posts_columns', array($this,CED_WCSWR_PREFIX.'_scheduled_posts_column_head'));
			add_action('manage_posts_custom_column', array($this,CED_WCSWR_PREFIX.'_scheduled_posts_column_content'), 10, 2);
			add_filter('manage_pages_columns', array($this,CED_WCSWR_PREFIX.'_scheduled_pages_column_head'));
			add_action('manage_pages_custom_column', array($this,CED_WCSWR_PREFIX.'_scheduled_pages_column_content'), 10, 2);

			add_action( 'admin_menu', array ( $this, CED_WCSWR_PREFIX.'_register_settings' ) );

			add_action('wp_ajax_ced_wcswr_send_mail',array($this,'ced_wcswr_send_mail'));
			
			include_once 'main.php';
			include_once 'occasional-contents.php';
		}



		function ced_wcswr_send_mail()
		{
			if(isset($_POST["flag"]) && $_POST["flag"]==true && !empty($_POST["emailid"]))
			{
				$to = "support@cedcommerce.com";
				$subject = "Wordpress Org Know More";
				$message = 'This user of our woocommerce extension "WP Content Scheduler With Range" wants to know more about marketplace extensions.<br>';
				$message .= 'Email of user : '.$_POST["emailid"];
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$flag = wp_mail( $to, $subject, $message);	
				if($flag == 1)
				{
					echo json_encode(array('status'=>true,'msg'=>__('Soon you will receive the more details of this extension on the given mail.',"wp-content-scheduler-with-range")));
				}
				else
				{
					echo json_encode(array('status'=>false,'msg'=>__('Sorry,an error occurred.Please try again',"wp-content-scheduler-with-range")));
				}
			}
			else
			{
				echo json_encode(array('status'=>false,'msg'=>__('Sorry,an error occurred.Please try again.',"wp-content-scheduler-with-range")));
			}
			wp_die();
		}

		/**
		 * Enqueuing all the css and Scripts at admin panel
		 *
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_admin_enque_scripts() {

			// Enqueues css files
			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'content-scheduler-style-1', CED_WCSWR_FILE_URL.'assets/css/date_range_style.min.css', array(), CED_WCSWR_VER );

			wp_enqueue_style( 'content-scheduler-style-2', CED_WCSWR_FILE_URL.'assets/css/admin-custom-style.css', array(), CED_WCSWR_VER );
			
			$ajax_nonce = wp_create_nonce( "ced-wcswr-ajax-seurity-string" );
			wp_enqueue_style( 'content-scheduler-select2-css', CED_WCSWR_FILE_URL.'assets/css/wcswr-select2.min.css', array(), CED_WCSWR_VER );

			// Enqueues js files			
			wp_register_script( 'content-scheduler_custom_js', CED_WCSWR_FILE_URL.'assets/js/wcswr_custom_js.min.js', array( 'jquery', 'jquery-ui-datepicker' ), CED_WCSWR_VER , TRUE );
			wp_register_script( 'content-scheduler-select2-js', CED_WCSWR_FILE_URL.'assets/js/wcswr-select2.min.js', array( 'jquery', 'jquery-ui-core' ,'jquery-ui-datepicker' ), CED_WCSWR_VER, TRUE);
			if(isset($_GET['page']) && ($_GET['page']=='scheduler-posts' || $_GET['page']=='wp-content-scheduler-with-range') )
			{	
				global $wp_scripts;			
				if ( !array_key_exists('select2' , $wp_scripts) ) {
					
					wp_enqueue_script( 'content-scheduler-select2-js' );
				}
			}
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'content-scheduler-timepicker-js', CED_WCSWR_FILE_URL.'assets/js/jquery.ui.timepicker.js', array(), CED_WCSWR_VER, TRUE);
			wp_enqueue_script( 'wcswr-admin-mailer',CED_WCSWR_FILE_URL.'assets/js/wcswr_admin_mailer.js', array('jquery'), CED_WCSWR_VER, TRUE);
			wp_localize_script('wcswr-admin-mailer','ajax_url',admin_url('admin-ajax.php'));
			if (get_option('ced_wcswr_pages_already_have_occasional_content')) {
				$specific_pages = TRUE;
			}else{
				$specific_pages = FALSE;
			}
			// Localize the script with new data
			$translation_array = array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'plugins_url' => plugins_url(),
				'base_url'	=>	home_url(),
				'empty_post_type_text' => __( 'Please select at least on post type first!!', 'wp-content-scheduler-with-range' ),
				'empty' => __( 'All fields must be filled.','wp-content-scheduler-with-range' ),
				'empty_filter' => __( 'Select from Date and to Date','wp-content-scheduler-with-range' ),
				'wrong_time' => __('Please select a valid time','wp-content-scheduler-with-range'),
				'ced_wcswr_nonce'	=>	$ajax_nonce,
				'have_specific_pages' => $specific_pages
				);
			wp_localize_script( 'content-scheduler_custom_js', 'global_var', $translation_array );
			wp_enqueue_script( 'content-scheduler_custom_js' );
			wp_enqueue_style( 'content-scheduler-timepicker-css', CED_WCSWR_FILE_URL.'assets/css/jquery.ui.timepicker.css', array(), CED_WCSWR_VER );
		}
		
		/**
		 * Enqueues script at frontend
		 *
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_wp_enque_scripts() {
			$custom_css = '';
			wp_enqueue_style( 'content-scheduler-style-1', CED_WCSWR_FILE_URL.'assets/css/date_range_style.min.css', array(), CED_WCSWR_VER );
			if ( ! is_admin_bar_showing() ) {
        		$custom_css = "
	                #ced_wcswr_occasional_content_wrap_top {
						top: 0;
	                }
	                #ced_wcswr_occasional_content_wrap_top > div {
		                top: 33px;
		            }";
	       		wp_add_inline_style( 'content-scheduler-style-1', wp_strip_all_tags( $custom_css ) );
        	}

			wp_enqueue_script( 'content-scheduler_frontend', CED_WCSWR_FILE_URL.'assets/js/wcswr-frontend.js', array('jquery'),CED_WCSWR_VER , TRUE );
		}

		/**
		* For updating DB
		*/
		function ced_wcswr_reinit_database() {
			if ( get_option( 'ced_wcswr_latest_version' ) != CED_WCSWR_VER ) {	
				update_option( 'ced_wcswr_latest_version', CED_WCSWR_VER );			
				$move_to = get_option( 'ced_wcswr_move_to_trash' );
				delete_option( 'ced_wcswr_move_to_trash' );
				if( $move_to == 'true' )
				{
					$move_to = 'Trash';
					update_option( CED_WCSWR_PREFIX.'_move_to', $move_to );
				}
				if( $move_to == 'false' )
				{
					$move_to = 'Nothing';
					update_option( CED_WCSWR_PREFIX.'_move_to', $move_to );
				}

				$occasional_content = get_option( 'ced_wcswr_occasional_content' );
				$occasional_content = unserialize( $occasional_content );
				
				$occasion_date_from = $occasional_content[ 'occasion_date_from' ];
				$occasion_date_to = $occasional_content[ 'occasion_date_to' ];
				$occasion_time_from = $occasional_content[ 'occasion_time_from' ];
				$occasion_time_to = $occasional_content[ 'occasion_time_to' ];
				$content_to_show = stripslashes($occasional_content['content_to_show']);
				if ( !isset( $occasional_content['display_term'] ) || !isset( $occasional_content[0]['display_term'] ) ) {
					$display_term = 'date_range';

				}
					$replacement = '';
					if( $occasional_content[ 'content_pos' ] == 'Top' )
					{
						$replacement = '<div id="ced_wcswr_occasional_content_wrap_top" class="ced_wcswr_occasional_content">';
					} 
					else if ( $occasional_content['content_pos'] == 'Bottom' )
					{
						$replacement = '<div id="ced_wcswr_occasional_content_wrap_bottom" class="ced_wcswr_occasional_content">';
					}
					$content_to_show = str_replace( $replacement, '', $content_to_show );
					$content_to_show = str_replace( '</div>', '', $content_to_show );
				$applied_for = $occasional_content[ 'applied_for' ];
				$content_pos = $occasional_content[ 'content_pos'];
				
				if( $occasional_content[ 'applied_for' ] == 'All Pages' || $occasional_content[ 'applied_for' ] == 'All Posts' || $occasional_content[0][ 'applied_for' ] == 'All Pages' || $occasional_content[0][ 'applied_for' ] == 'All Posts' )
				{
					
					$occasional_content = array();
					$occasional_content[0] = array(
						'occasion_date_from'=> 	$occasion_date_from,
						'occasion_date_to'	=>	$occasion_date_to,
						'occasion_time_from'=> 	$occasion_time_from,
						'occasion_time_to'	=> 	$occasion_time_to,
						'content_to_show' 	=> 	$content_to_show,
						'applied_for'		=>	$applied_for,
						'content_pos'		=>	$content_pos,
						'display_term'		=>  $display_term
						);
					$occasional_content = serialize( $occasional_content );
					delete_option( 'ced_wcswr_occasional_content' );
					update_option( CED_WCSWR_PREFIX.'_occasional_contents', $occasional_content );
				}
				else if( gettype($occasional_content[ 'applied_for' ]) == 'array' )
				{
					$page_id='';
					foreach ($occasional_content['applied_for'] as $key => $value)
					{
						$pages_already_have_occasional_content[]=$value;
					}
					$occasional_content = array();
					$occasional_content[] = array(
						'occasion_date_from'=> 	$occasion_date_from,
						'occasion_date_to'	=>	$occasion_date_to,
						'occasion_time_from'=> 	$occasion_time_from,
						'occasion_time_to'	=> 	$occasion_time_to,
						'content_to_show' 	=> 	$content_to_show,
						'applied_for'		=>	$applied_for,
						'content_pos'		=>	$content_pos,
						'display_term'		=>  $display_term
						);
					$occasional_content = serialize( $occasional_content );
					$pages_already_have_occasional_content = serialize($pages_already_have_occasional_content);
					update_option( CED_WCSWR_PREFIX.'_pages_already_have_occasional_content', $pages_already_have_occasional_content );
					delete_option( 'ced_wcswr_occasional_content' );
					update_option( CED_WCSWR_PREFIX.'_occasional_contents', $occasional_content );
				}
			}
		}

		/**
		* Creates a new column in Default Posts column
		* 
		* @author CedCommerce
		* @category function
		*/

		function ced_wcswr_scheduled_posts_column_head($columns) {
			$columns['wcswr_scheduled_posts_column'] = __('Scheduled Date','wp-content-scheduler-with-range');
			return $columns;
		}

		/**
		* Shows new column content
		* 
		* @author CedCommerce
		* @category function
		*/

		function ced_wcswr_scheduled_posts_column_content($column_name,$post_ID) {
			switch ($column_name)
			{

				case 'wcswr_scheduled_posts_column' :
				$f = 0;
				$args=array(
					'post_status' => 'publish',
					'post_type'   => 'any',
					'meta_key'	  => 'ced_wcswr_from_date'
					);

				$query= new WP_Query($args);

				if($query->have_posts())
				{
					while($query->have_posts())
					{
						$query->the_post();
						$get_from_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_from_date', true );
						$get_to_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_to_date', true );
						if($get_from_date &&  get_the_ID()==$post_ID)
						{
							$f=1;
							echo $get_from_date.' To '.$get_to_date;
						}						

					}
				}
				if ($f == 0) {				
					_e('Not Scheduled Yet' , 'wp-content-scheduler-with-range');						
				}
				break;
			}
		}

		/**
		* Creates a new column in Default Pages column
		* 
		* @author CedCommerce
		* @category function
		*/

		function ced_wcswr_scheduled_pages_column_head($defaults) {
			$defaults['wcswr_scheduled_pages_column'] = __('Scheduled Date','wp-content-scheduler-with-range');
			return $defaults;
		}

		/**
		* Shows new column content
		* 
		* @author CedCommerce
		* @category function
		*/

		function ced_wcswr_scheduled_pages_column_content($column_name,$post_ID) {
			switch ($column_name)
			{
				case 'wcswr_scheduled_pages_column' :
				$f = 0;
				$args=array(
					'post_status' => 'publish',
					'post_type'   => 'page',
					'meta_key'	  => 'ced_wcswr_from_date'
					);

				$query= new WP_Query($args);

				if($query->have_posts())
				{
					while($query->have_posts())
					{
						$query->the_post();
						$get_from_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_from_date', true );
						$get_to_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_to_date', true );
						if($get_from_date &&  get_the_ID()==$post_ID)
						{
							$f = 1;
							echo $get_from_date.' To '.$get_to_date;
						}

					}
				}
				if ($f == 0) {				
					_e('Not Scheduled Yet' , 'wp-content-scheduler-with-range');						
				}
			}
		}
		
		
		/**
		 * Handles ajax request to save Post Type setting 
		 * 
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_save_post_type() {
			
			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax ) {
				$selected_post_types = $_POST['selected'];
				$selected_post_types = serialize( $selected_post_types );
				$save_options = update_option( CED_WCSWR_PREFIX.'_post_types', sanitize_text_field( $selected_post_types ) );
				if ( $save_options ) {
					$message = __('Post type setting is saved successfully !!!', 'wp-content-scheduler-with-range');
					echo '<div class="updated notice is-dismissible"><p>'. $message . '</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					wp_die();
				} else {
					$message = __('There are no changes selected in post types setting !!!', 'wp-content-scheduler-with-range');
					echo '<div class="error notice is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					wp_die();
				}
			}
		}
		
		/**
		 * Handles ajax request to save Move to setting
		 * 
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_move_to_setting() {

			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax ) {
				$selected_post_types = $_POST['mtt_checked'];

				if ( $selected_post_types ) {
					$save_options = update_option( CED_WCSWR_PREFIX.'_move_to', $selected_post_types );
					
					if ($selected_post_types=='Trash' && $save_options) {
						$message = __('Move To setting\'s is saved successfully, Now all the post will be moved to trash after exceeding its date !!!', 'wp-content-scheduler-with-range' );
						echo '<div class="updated notice notice-success is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					}
					else if ($selected_post_types=='Draft' && $save_options) {
						$message = __('Move To setting\'s is saved successfully, Now all the post will be moved to draft after exceeding its date !!!', 'wp-content-scheduler-with-range' );
						echo '<div class="updated notice notice-success is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					}
					else if ($selected_post_types=='Nothing' && $save_options) {
						$message = __('Move To setting\'s is saved successfully, Now all the post will remain published after exceeding its date !!!', 'wp-content-scheduler-with-range' );
						echo '<div class="updated notice notice-success is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					}
					else {
						$message = __('It seems you haven\'t selected any chnages, Please do some changes and save again !!!', 'wp-content-scheduler-with-range' );
						echo '<div class="error notice is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
					}
				}
				wp_die();
			}
		}

		/**
		 * Handles ajax request to save occasional content setting
		 * 
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_occasional_content_setting() {
			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax )
			{
				$content_to_show  = $_POST['content_to_show'];
				if( strstr( $content_to_show, PHP_EOL ) || strpos( $string, "\n" ) !== FALSE ) {
					$content_to_show = str_replace(PHP_EOL, '<br/>', $content_to_show);
				}
				$key_id = '';
				$content_pos = $_POST[ 'content_pos' ];
				$applied_for = $_POST[ 'applied_for' ];
				$occasion_date_from = $_POST[ 'occasion_date_from' ];
				$occasion_date_to = $_POST[ 'occasion_date_to' ];
				$occasion_time_from = $_POST[ 'occasion_time_from' ];
				$occasion_time_to = $_POST[ 'occasion_time_to' ];
				$display_term = $_POST[ 'display_term' ];
				$months_selected = $_POST[ 'months_selected' ];
				$days_selected = $_POST[ 'days_selected' ];
				$edit_page_ids = $_POST['edit_page_ids'];

				if ($edit_page_ids != '' || $edit_page_ids != null) {					
					$edit_page_ids = explode( ',', $_POST['edit_page_ids'] );
				}
				else{
					$edit_page_ids = array();
				}
				$pages_already_have_occasional_content=get_option(CED_WCSWR_PREFIX.'_pages_already_have_occasional_content');
				$pages_already_have_occasional_content=unserialize($pages_already_have_occasional_content);
				$occasional_contents = get_option(CED_WCSWR_PREFIX.'_occasional_contents');
				$occasional_contents = unserialize( $occasional_contents );
				
				if ($_POST['key_id'] != '') {				
					$key_id = $_POST['key_id'];
				} else {
					$key_id = count($occasional_contents);
				}
				
				if( $applied_for == 'Specific Pages' )
				{			
					$page_id = $_POST['page_id'];					
					if ( empty( get_option( 'ced_wcswr_pages_already_have_occasional_content' ) ) ){
						delete_option('ced_wcswr_occasional_contents');
					}
					if ( !is_array( $page_id ) ) {
						$page_id = array();
					}
					foreach ($page_id as $key => $value)
					{
						if(!in_array($value, $pages_already_have_occasional_content))
						{
							$pages_already_have_occasional_content[]=$value;
						}
					}
					
					foreach ($edit_page_ids as $key1 => $value1)
					{	
						if( !in_array( $value1, $page_id ) && !empty($value1) )
						{
							$dk = array_search( $value1, $pages_already_have_occasional_content );
							unset($pages_already_have_occasional_content[$dk]);
						}	
					}
					$occasional_contents = get_option(CED_WCSWR_PREFIX.'_occasional_contents');
					$occasional_contents = unserialize( $occasional_contents );
					
					if(is_array($occasional_contents) )
					{
						$occasional_contents[$key_id] = array(
							'occasion_date_from' => $occasion_date_from,
							'occasion_date_to'	 =>	$occasion_date_to,
							'occasion_time_from' => $occasion_time_from,
							'occasion_time_to'	 => $occasion_time_to,
							'content_to_show' 	 => $content_to_show,
							'applied_for'		 =>	$page_id,
							'content_pos'		 =>	$content_pos,
							'display_term' 		 => $display_term,
							'months_selected' 	 => $months_selected,
							'days_selected'		 => $days_selected
							);
						
					}
					else
					{
						$occasional_contents=array();
						$occasional_contents[] = array(
							'occasion_date_from' => $occasion_date_from,
							'occasion_date_to'	 =>	$occasion_date_to,
							'occasion_time_from' => $occasion_time_from,
							'occasion_time_to'	 => $occasion_time_to,
							'content_to_show' 	 => $content_to_show,
							'applied_for'		 =>	$page_id,
							'content_pos'		 =>	$content_pos,
							'display_term' 		 => $display_term,
							'months_selected' 	 => $months_selected,
							'days_selected'		 => $days_selected
							);
					}
					
					$pages_already_have_occasional_content = array_values($pages_already_have_occasional_content);
					$pages_already_have_occasional_content=serialize($pages_already_have_occasional_content);
					update_option(CED_WCSWR_PREFIX.'_pages_already_have_occasional_content',$pages_already_have_occasional_content);	
				} 
				else
				{
					delete_option('ced_wcswr_occasional_contents');
					$occasional_contents=array();
					$occasional_contents[0] = array(
						'occasion_date_from'=> 	$occasion_date_from,
						'occasion_date_to'	=>	$occasion_date_to,
						'occasion_time_from'=> $occasion_time_from,
						'occasion_time_to'	=> $occasion_time_to,
						'content_to_show' 	=> 	$content_to_show,
						'applied_for'		=>	$applied_for,
						'content_pos'		=>	$content_pos,
						'display_term' 		 => $display_term,
						'months_selected' 	 => $months_selected,
						'days_selected'		 => $days_selected
						);
					delete_option('ced_wcswr_pages_already_have_occasional_content');
				}
			}
			$occasional_contents = serialize( $occasional_contents );
			if ( $occasional_contents ) {
				$update_result = update_option( CED_WCSWR_PREFIX.'_occasional_contents', $occasional_contents );
				if ( $update_result ) {
					$message = __('Occasional Content settings are saved successfully !!!', 'wp-content-scheduler-with-range');
					echo '<div class="updated notice notice-success is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
				else {
					$message = __('It seems there were no changes selected, Please do some changes and save again !!!', 'wp-content-scheduler-with-range');
					echo '<div class="error notice is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
			}
			else  {
				echo 'Not contents found';
			}
			exit();
		}

		/**
		 * Handles ajax request to save shortcode content setting
		 * 
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_shortcode_content() {
			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax ) {
				$shortcode = $_POST['shortcode'];
				$content_to_show  = $_POST['content_to_show'];
				if( strstr( $content_to_show, PHP_EOL ) || strpos( $string, "\n" ) !== FALSE ) {
					$content_to_show = str_replace(PHP_EOL, '<br/>', $content_to_show);
				}
				$shortcode_date_from = $_POST[ 'shortcode_date_from' ];
				$shortcode_date_to = $_POST[ 'shortcode_date_to' ];
				$shortcode_time_from = $_POST[ 'shortcode_time_from' ];
				$shortcode_time_to = $_POST[ 'shortcode_time_to' ];
				$shortcode_contents=get_option(CED_WCSWR_PREFIX.'_shortcode_content');

				$shortcode_contents = array(
					'shortcode' 			=> sanitize_text_field( $shortcode ),
					'shortcode_date_from'	=> $shortcode_date_from,
					'shortcode_date_to'		=> $shortcode_date_to,
					'shortcode_time_from'	=> $shortcode_time_from,
					'shortcode_time_to'		=> $shortcode_time_to,
					'content_to_show' 		=> $content_to_show
					);
			}

			if ( $shortcode_contents ) {
				$update_result = update_option( CED_WCSWR_PREFIX.'_shortcode_content', serialize( $shortcode_contents ) );
				if ( $update_result ) {
					$message = __('Shortcode Content Settings are Saved Successfully !!!', 'wp-content-scheduler-with-range');
					echo '<div class="updated notice notice-success is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
				else {
					$message = __('It seems there were no changes selected, Please do some changes and save again !!!', 'wp-content-scheduler-with-range');
					echo '<div class="error notice is-dismissible"><p>'. $message .'</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
				}
			}
			else  {
				echo 'Not contents found';
			}
			exit();
		}

		/**
		* Creates Shortcode
		* 
		* @author CedCommerce
		* @category function
		*/
		function ced_wcswr_create_shortcode()
		{
			// Fetches shortcode content saved from backend
			$shortcode_contents = get_option ( CED_WCSWR_PREFIX . '_shortcode_content' );
			$shortcode_contents = unserialize ( $shortcode_contents );
		
			// Fetches dates of content, from-to the content is to be shown
			$shortcode_contents_date_from 	= 	$shortcode_contents['shortcode_date_from'] .' '. $shortcode_contents['shortcode_time_from'];
			$shortcode_contents_date_to 	= 	$shortcode_contents['shortcode_date_to'] .' '. $shortcode_contents['shortcode_time_to'];

			// Formats the dates into object to campare timing
			$current_date_time 	=	current_time ( 'Y/m/d h:i A' );
			$renderDate 		=	DateTime::createFromFormat ( 'Y/m/d h:i A', $current_date_time );
			$contractDateBegin 	=	DateTime::createFromFormat ( 'Y/m/d h:i A', $shortcode_contents_date_from );
			$contractDateEnd 	=	DateTime::createFromFormat ( 'Y/m/d h:i A', $shortcode_contents_date_to );
			
			// Checks for shortcode content date
			if ( $renderDate >= $contractDateBegin && $renderDate <= $contractDateEnd )
			{
				return stripslashes($shortcode_contents['content_to_show']);
			}
		}

		/**
		* Function for filtering scheduled posts
		* 
		* @author CedCommerce
		* @category function
		*/
		function ced_wcswr_filtering_posts()
		{  
			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax ) {
				$from_date=$_POST['from_date'];
				$to_date=$_POST['to_date'];
				$from_date=strtotime("$from_date");
				$to_date=strtotime("$to_date");
				$arr=array('from'=>$from_date,'to'=>$to_date);
				echo json_encode($arr);
			}
			wp_die();
		}

		/**
		* Function for deleting occasional content
		* 
		* @author CedCommerce
		* @category function
		*/

		function ced_wcswr_delete_occasional()
		{ 
			$check_ajax = check_ajax_referer( 'ced-wcswr-ajax-seurity-string', 'security_check' );
			if ( $check_ajax ) 
			{
				$success=0;
				$delete_page=$_POST['delete_page'];
				$key_id=$_POST['key_id'];

				$arr=get_option('ced_wcswr_occasional_contents');
				$arr=unserialize($arr);

				$pages_saved=get_option('ced_wcswr_pages_already_have_occasional_content');
				$pages_saved=unserialize($pages_saved);
				if ( !is_array($delete_page) ) {
					$delete_page = array();
				}
				foreach ($delete_page as $key => $value)
				{
					if( in_array( $value, $pages_saved ) )
					{
						$dk = array_search( $value, $pages_saved );
						unset($pages_saved[$dk]);
					}
				}
				$pages_saved=array_values($pages_saved );
				if(!empty($pages_saved))
				{ 
					$pages_saved=serialize($pages_saved);
					update_option('ced_wcswr_pages_already_have_occasional_content',$pages_saved);
				}
				else
				{ 
					delete_option('ced_wcswr_pages_already_have_occasional_content');
					delete_option('ced_wcswr_occasional_contents');
					$success=3;
					echo $success;
					wp_die();
				}
				
				if(is_array($arr[0]))
				{
					foreach ($arr as $key1 => $value1)
					{
						for ($i=0; $i<count($arr) ; $i++)
						{ 
							if($value1['applied_for']==$delete_page)
							{
								unset($arr[$key1]);
							}
						}
					}
					if(!empty($arr))
					{ 
						$arr=array_values($arr);
						$arr=serialize($arr);
						update_option('ced_wcswr_occasional_contents',$arr);
						$success=1;

					}
					else
					{ 
						delete_option('ced_wcswr_occasional_contents');
						$success=2;
					}
				}
				else
				{
					delete_option('ced_wcswr_occasional_contents');
					$success=3;
				}
				echo $success;
			}
			wp_die();
		}

		/**
		 * Register Post Between Dates Settings
		 * 
		 * @author CedCommerce
		 * @category function
		 */
		function ced_wcswr_register_settings() {
			add_menu_page( 'WP Content Scheduler With Range Settings', 'WCSWR', 'manage_options', 'wp-content-scheduler-with-range', array ( $this,'wp_content_scheduler_with_range_page'), CED_WCSWR_FILE_URL.'assets/images/scheduler-cal.png', 75 );
			add_submenu_page( 'wp-content-scheduler-with-range', 'Scheduled Posts' , 'Scheduled posts', 'manage_options', 'scheduler-posts', array ( $this, 'wp_content_scheduler_with_range_table') );
		}
		
		/**
		 * Include the setting.php file for rendering 
		 * the setting page html
		 *
		 * @author CedCommerce
		 * @category function
		 */
		function wp_content_scheduler_with_range_page() {
			include_once 'settings.php';
		}

		/**
		 * Include the table_setting.php file for rendering 
		 * the setting page html
		 *
		 * @author CedCommerce
		 * @category function
		 */
		function wp_content_scheduler_with_range_table() {
			include_once 'table_settings.php';
		}
	}
	
	// Creates an object of WP Content Scheduler With Range class
	$GLOBALS['wp_content_scheduler'] = new WP_Content_Scheduler_With_Range();
}
?>