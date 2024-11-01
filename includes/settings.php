<?php
if (! defined ( 'ABSPATH' )) 
{
	exit (); // Exit if accessed directly
}

// Fetches saved post type settings
$saved_post_types = get_option ( CED_WCSWR_PREFIX.'_post_types' );
// Converts fetched data to array
$saved_post_types = unserialize ( $saved_post_types );

// Fetches pages_already_have_occasional_content settings
$pages_already_have_occasional_content = get_option ( CED_WCSWR_PREFIX.'_pages_already_have_occasional_content' );
// Converts fetched data to array
$pages_already_have_occasional_content = unserialize ( $pages_already_have_occasional_content );

// Fetches shortcode settings
$shortcode_content = '';
$shortcode_content = get_option ( CED_WCSWR_PREFIX.'_shortcode_content' );
// Converts fetched data to array
$shortcode_content = unserialize ( $shortcode_content );

// Fetches move to trash setting
$move_to=get_option( CED_WCSWR_PREFIX. '_move_to' );
$nothing=''; $trash=''; $draft='';
if($move_to=='Draft')
{ 
	$draft='selected="selected"';
}
elseif($move_to==='Trash') 
{ 
	$trash='selected="selected"';
}
else
{
	$nothing='selected="selected"';
}
global $wp_post_types;


// Fetches occasional content saved from backend
$occasional_contents = get_option( CED_WCSWR_PREFIX.'_occasional_contents' );
$occasional_contents = unserialize( $occasional_contents );
$applied_for=''; $content=''; $top=''; $bottom='';

if(isset($occasional_contents[0]) && is_array($occasional_contents[0]) && !empty($occasional_contents) )
{
	$occasional_contents= array_values($occasional_contents);
}

if(isset($_GET["ced_wcswr_close"]) && $_GET["ced_wcswr_close"])
{
	unset($_GET["ced_wcswr_close"]);
	if(!session_id())
		session_start();
	$_SESSION["ced_wcswr_hide_email"]=true;
}
?>
<div id="<?php echo CED_WCSWR_PREFIX; ?>_messages"></div>
<div class="<?php echo CED_WCSWR_PREFIX; ?>_container"> <!--end's at last of page-->
	<h2 class="<?php echo CED_WCSWR_PREFIX; ?>_setting_wrapper"><?php _e('WP Content Scheduler With Range Settings', 'wp-content-scheduler-with-range');?></h2>
	<?php if($_SESSION["ced_wcswr_hide_email"] == true){	?>
			<div class="ced-promotional-sidebar-wrapper ced-full-width">
		<?php } ?>
	<div class="ced-promotional-sidebar-wrapper">
	<div class="ced-promotional-sidebar">
	<div class="<?php echo CED_WCSWR_PREFIX; ?>_toggle_tabs">
		<div id="<?php echo CED_WCSWR_PREFIX; ?>_tab1" class="<?php echo CED_WCSWR_PREFIX; ?>_tabs <?php echo CED_WCSWR_PREFIX; ?>_active">
			<?php _e('Post Type', 'wp-content-scheduler-with-range');?>
		</div>
		<div id="<?php echo CED_WCSWR_PREFIX; ?>_tab2" class="<?php echo CED_WCSWR_PREFIX; ?>_tabs">
			<?php _e('Move To', 'wp-content-scheduler-with-range');?>
		</div>
		<div id="<?php echo CED_WCSWR_PREFIX; ?>_tab3" class="<?php echo CED_WCSWR_PREFIX; ?>_tabs">
			<?php _e('Occasional  Content', 'wp-content-scheduler-with-range');?>
		</div>
		<div id="<?php echo CED_WCSWR_PREFIX; ?>_tab4" class="<?php echo CED_WCSWR_PREFIX; ?>_tabs">
			<?php _e('Create Shortcode','wp-content-scheduler-with-range');?>
		</div>
	</div>

	<div class="<?php echo CED_WCSWR_PREFIX; ?>_wrap_settings">

		<!--post type starts-->
		<div class="<?php echo CED_WCSWR_PREFIX; ?>_settings_wrapper <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content1">
			<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post_type <?php echo CED_WCSWR_PREFIX; ?>_default">
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post">
					<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
						<label class="<?php echo CED_WCSWR_PREFIX; ?>-select-post-type-label">
							<strong> 
								<?php _e('Select Post Types:', 'wp-content-scheduler-with-range');?>
							</strong>
						</label>
					</div> 
					<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
						<select class="<?php echo CED_WCSWR_PREFIX; ?>-select2" id="select_post_type" multiple="multiple">
							<?php							
							foreach ( $wp_post_types as $post_type => $info ) 
							{
								if ($post_type != 'attachment' && $post_type != 'revision' && $post_type != 'nav_menu_item' && $post_type != 'product_variation' && $post_type != 'shop_order' && $post_type != 'shop_order_refund' && $post_type != 'shop_coupon' && $post_type != 'shop_webhook') 
								{
									?>
									<option value="<?php echo $post_type;?>" data="<?php echo $info->labels->singular_name;?>"><?php echo $info->labels->singular_name;?></option>
									<?php 
								}
							}
							?>
						</select>
					</div>
				</div>
			</div>

			<?php 
			if ( ! empty( $saved_post_types ) ) 
			{
				?>
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_selected_post_type <?php echo CED_WCSWR_PREFIX; ?>_default">
					<div class="selected_post_types">
						<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
							<label class="<?php echo CED_WCSWR_PREFIX; ?>-select-post-type-label">
								<strong> 
									<?php _e('Selected Post Types:','wp-content-scheduler-with-range');?>
								</strong>
							</label> 
						</div>
						<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
							<span>
								<?php
								foreach ( $wp_post_types as $post_type_slug => $info ) 
								{
									foreach ( $saved_post_types as $index => $post_type ) 
									{
										if ($post_type_slug == $post_type) 
										{
											echo $info->labels->singular_name;
											if ($index < count ( $saved_post_types ) - 1) 
											{
												echo ', ';
											}
										}
									}
								}
								?>
							</span>
						</div>
					</div>
				</div>
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn_wrapper">
					<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn">
						<button type="button" id="<?php echo CED_WCSWR_PREFIX; ?>_save_settings" class="<?php echo CED_WCSWR_PREFIX; ?>_button button-primary" value=""><?php _e('Update','wp-content-scheduler-with-range');?></button>
						<img src="<?php echo CED_WCSWR_PLUGIN_URL?>/assets/images/loading.gif" class="<?php echo CED_WCSWR_PREFIX; ?>_post_type_loding_img">
					</div>
				</div>
				<?php 
			} 
			else 
				{	?>
			<div class="<?php echo CED_WCSWR_PREFIX; ?>_selected_post_type <?php echo CED_WCSWR_PREFIX; ?>_default">
				<div class="selected_post_types">
					<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
						<label class="<?php echo CED_WCSWR_PREFIX; ?>-select-post-type-label">
							<strong> 
								<?php _e('Selected Post Types:','wp-content-scheduler-with-range');?>
							</strong>
						</label> 
					</div>
					<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
						<span>
							<?php _e('No Post Types selected yet.','wp-content-scheduler-with-range');?>
						</span>
					</div>
				</div>
			</div>
			<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn_wrapper">
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn">
					<button type="button" id="<?php echo CED_WCSWR_PREFIX; ?>_save_settings" class="<?php echo CED_WCSWR_PREFIX; ?>_button button-primary" value=""><?php _e('Save','wp-content-scheduler-with-range');?></button>
					<img src="<?php echo CED_WCSWR_PLUGIN_URL?>/assets/images/loading.gif" class="<?php echo CED_WCSWR_PREFIX; ?>_post_type_loding_img">
				</div>
			</div>	
			<?php 
		}	?>
	</div> <!--post type ends-->

<!-- Move to start -->
<div class="<?php echo CED_WCSWR_PREFIX; ?>_move_to <?php echo CED_WCSWR_PREFIX; ?>_default <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content2">
	<div class="<?php echo CED_WCSWR_PREFIX; ?>_move_to_input">

		<div class="<?php echo CED_WCSWR_PREFIX; ?>-move-to-lt_wrapper">
			<label class="<?php echo CED_WCSWR_PREFIX; ?>-select-post-type-label"> <strong><?php _e('Move to :','wp-content-scheduler-with-range');?> </strong>
				&nbsp;<a title="<?php echo _('If you want to move post into trash or draft after schedule time')?>" href="#" id="help-prod0"><img width="16" height="16" src="<?php echo CED_WCSWR_PLUGIN_URL?>assets/images/icons.png"></a>						
			</label>				
		</div>

		<div class="<?php echo CED_WCSWR_PREFIX; ?>-move-to-rt_wrapper">
			<select id="move_to_options">
				<option id="nothing" <?php echo $nothing;  ?>> <?php _e('Nothing','wp-content-scheduler-with-range');?></option>
				<option id="trash" <?php echo $trash;  ?>> <?php _e('Trash','wp-content-scheduler-with-range');?></option>
				<option id="draft" <?php echo $draft;  ?>> <?php _e('Draft','wp-content-scheduler-with-range');?></option>
			</select>
		</div>

		<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn_wrapper">
			<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn">
				<button type="button" id="<?php echo CED_WCSWR_PREFIX; ?>_move_to" class="<?php echo CED_WCSWR_PREFIX; ?>_button button-primary" value=""><?php _e('Save','wp-content-scheduler-with-range');?></button>
				<img src="<?php echo CED_WCSWR_PLUGIN_URL?>/assets/images/loading.gif" class="<?php echo CED_WCSWR_PREFIX; ?>_move_to_loding_img">
			</div>
		</div>	
	</div>
</div> <!-- move to end's -->

<!--occassional content start's -->
<div class="wrap" id="ced_wcswr_wrap">
	<h2 class="nav-tab-wrapper" id="wcswr-nav-tab-wrapper">
		<div id="nav-tab1" class="nav-tab"><?php _e('Add Occassional Content','wp-content-scheduler-with-range'); ?></div>			    
		<div id="nav-tab2" class="nav-tab"><?php _e('Occassional Contents','wp-content-scheduler-with-range'); ?></div>
	</h2>
</div>

<!-- tab_content3_1 starts -->
<div class="<?php echo CED_WCSWR_PREFIX; ?>_settings_wrapper <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content3_1">
	<?php
	global $wp_post_types;
	?>
	<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post_type1 <?php echo CED_WCSWR_PREFIX; ?>_default">
		<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post">
			<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
				<label class="<?php echo CED_WCSWR_PREFIX; ?>-content-applied-for-label"> 
					<strong> 
						<?php _e('Apply For:', 'wp-content-scheduler-with-range');?>
					</strong>
				</label>
			</div>

			<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
				<select id="applied_options">
					<option id="select" value="Select" ><?php _e('Select','wp-content-scheduler-with-range');?></option>
					<option id="All Posts" value="All Posts" ><?php _e('All Posts','wp-content-scheduler-with-range');?></option>
					<option id="All Pages" value="All Pages"><?php _e('All Pages','wp-content-scheduler-with-range');?></option>
					<option id="Specific Pages" value="Specific Pages"><?php _e('Specific Pages','wp-content-scheduler-with-range');?></option>
				</select>
				<span class="ced_wcswr_warn">
					<code><em>
						<?php _e('Selecting a new option from "Apply For" dropdown. You will loose your occasional content data.');
						?>
					</em></code>
				</span>

				<?php 
				global $wpdb;
				if (is_array($applied_for)) {
					$post_title = '';
					foreach ($applied_for as $post_id) {
						$post_title[] = $wpdb->get_results ( "SELECT `post_title` FROM `". $wpdb->posts ."` WHERE `ID` = '".$post_id."' " );
					}
					?>
					<p id="<?php echo CED_WCSWR_PREFIX; ?>_selected_specific_pages">
						<?php 
						foreach ($post_title as $key => $val){
							echo $val[0]->post_title;
							if ($key < count ( $post_title ) - 1) {
								echo ', ';
							}
						}
						?>
					</p> 
					<?php } ?>
				</div>
			</div>
		</div>

	</div> <!--tab_content3_1 ends-->

	<!-- tab_content3_2 starts -->
	<div class="<?php echo CED_WCSWR_PREFIX; ?>_extra_content <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content3_2">

		<?php
		if(!is_array($occasional_contents))
		{
			echo '<p id="no_content">'. __('No Content To Show. Add Some Occassional Content First.','wp-content-scheduler-with-range'); '</p>';
		}
		else
		{
			?>		
			<table class="wp-list-table widefat fixed striped posts" id="occasional_contents_table">
				<thead>
					<tr>					
						<th id="content"><?php _e('Content','wp-content-scheduler-with-range'); ?></th>
						<th id="applied-for"><?php _e('Applied For','wp-content-scheduler-with-range'); ?></th>
						<th id="content-position"><?php _e('Content Position','wp-content-scheduler-with-range'); ?></th>
						<th id="rendering-dates"><?php _e('Rendering Type','wp-content-scheduler-with-range'); ?></th>
						<th id="rendering-time"><?php _e('Rendering Time','wp-content-scheduler-with-range') ?></th>				
					</tr>
				</thead>
				<tbody id="the-list">
					<?php
					if(isset($occasional_contents[0]) && is_array($occasional_contents[0]))
					{
						foreach ($occasional_contents as $key => $value) 
						{

							?>
							<?php 
							$page_id='';
							if (is_array($value['applied_for'])) {							
								foreach ($value['applied_for'] as $key1 => $value1)
								{
									if(!empty($page_id))
									{
										$page_id.= ','.$value1;
									}
									else
									{
										$page_id=$value1;
									}
								}
							}else{
								$applied_for = $value['applied_for'];
							}
							?>
							<tr>
								<td data-colname="Title" data-id="<?php echo $key; ?>" class="title column-title has-row-actions column-primary page-title">
									<?php 
									$content_to_show = '';
									$value['content_to_show'] = stripslashes($value['content_to_show']);
									if( strlen( $value['content_to_show'] ) > 50 ) { 
										$content_to_show = substr( $value['content_to_show'], 0, 50 ).'...';
									} else {
										$content_to_show = $value['content_to_show'];
									}
									?>
									<dt id="wcswr_edit_content"><?php echo $content_to_show; ?></dt>
									<dt id="wcswr_hide" hidden="hidden"><?php echo $value['content_to_show']; ?></dt>	

									<div class="row-actions">

										<span class="view"><a aria-label="" data-page_id="<?php echo $page_id;?>" data-page_name="<?php $check=gettype($value['applied_for']);
											if($check=='array')
											{
												$length=count($value['applied_for'])-1;
												foreach ($value['applied_for'] as $key => $value2) 
												{
													echo get_the_title($value2);
													if($length>$key)
													{
														echo ',';
													}
												}
											}else{
												echo $applied_for;
											}?>" rel="" href="javascript:;" id="ced_wcswr_edit_content"  data-display="<?php echo $value['display_term']; ?>" data-days=<?php echo json_encode($value['days_selected']); ?> data-from="<?php echo $value['occasion_date_from']; ?>" data-to="<?php echo $value['occasion_date_to']; ?>" data-months=<?php echo json_encode($value['months_selected']); ?>><?php _e('Edit','wp-content-scheduler-with-range'); ?></a> | </span>
											<span class="view"><a aria-label="" rel="" href="javascript:;" id="ced_wcswr_delete_content"><?php _e('Delete','wp-content-scheduler-with-range'); ?></a></span>
										</div>
									</td><!--content-->

									<td data-colname="Applied For" data-page_id="<?php echo $page_id; ?>" class="applied-for">
										<?php
										$check=gettype($value['applied_for']);
										if($check=="array")
										{
											$length=count($value['applied_for'])-1;
											foreach ($value['applied_for'] as $key => $value2) 
											{
												echo get_the_title($value2);
												if($length>$key)
												{
													echo ' ' . ',' . ' ' ;
												}
											}
										}
										else
										{
											echo $value['applied_for'];
										} 
										?>
									</td><!--applied for-->

									<td data-colname="Content Position" class="content-position">
										<?php echo $value['content_pos']; ?>	
									</td><!--content position-->
									<?php $days = ''; ?>
									<td data-colname="Rendering Date" class="rendering-date">
										<?php if ( $value['display_term'] && $value['display_term'] == 'weekly' ) {
											?>
											<span><?php echo strtoupper(preg_replace('/[^A-Za-z0-9\-]/', ' ', $value['display_term'])); ?></span>
											<?php foreach ($value['days_selected'] as $key1 => $value1) {
												$days.=strtoupper($value1).", ";
											} ?>
											<?php $days = substr($days, 0 , strlen($days)-2); ?>
											<span><?php _e('Days: ' , 'wp-content-scheduler-with-range'); ?><?php echo $days; ?></span>					
											<?php
										}else if( $value['display_term'] && $value['display_term'] == 'monthly' ){
											?>					
											<span><?php echo strtoupper(preg_replace('/[^A-Za-z0-9\-]/', ' ', $value['display_term'])); ?></span>
											<?php foreach ($value[ 'months_selected' ] as $key1 => $value1) {						
												$days.=strtoupper($value1).", ";
											} ?>
											<?php $days = substr($days, 0 , strlen($days)-2); ?>

											<span><?php _e('Months: ' , 'wp-content-scheduler-with-range'); ?><?php echo $days; ?></span>					
											<?php
										}else if( $value['display_term'] && $value['display_term'] == 'date_range' ){
											?>
											<span><?php echo strtoupper(preg_replace('/[^A-Za-z0-9\-]/', ' ', $value['display_term'])); ?></span>
											<?php echo '<p id="date_from">' . $value['occasion_date_from'] . '</p><span> to </span>'; ?>
											<?php echo '<p id="date_to">' . $value['occasion_date_to'] . '</p>'; ?>					
											<?php
										} else if( $value['display_term'] && $value['display_term'] == 'daily' ) {
											?>
											<span><?php echo strtoupper(preg_replace('/[^A-Za-z0-9\-]/', ' ', $value['display_term'])); ?></span>
											<?php
										}?>
									</td><!--rendering dates-->


									<td data-colname="Rendering Time" class="rendering-time">
										<?php echo '<p id="time_from">' . $value['occasion_time_from'] . '</p><span> to </span>' ; ?>
										<?php echo '<p id="time_to">' . $value['occasion_time_to'] . '</p>'; ?>	
									</td> <!--rendering time-->		
								</tr>
								<?php 	} 
							}
							?>
						</tbody>			
					</table>
					<?php } ?>
				</div> <!--tab_cntent3_2 ends-->

				<!-- tab_content3_3 starts -->
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_extra_content <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content3_3">

					<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post_type2">
						<div class="<?php echo CED_WCSWR_PREFIX; ?>_applied_for <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-label"> 
									<strong> 
										<?php _e('Select Pages:','wp-content-scheduler-with-range');?>
									</strong>
								</label>
							</div>
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
								<?php 
								global $wpdb;					
							// Fetching all the published posts from database
								$all_posts = $wpdb->get_results ( "SELECT `ID`,`post_title` FROM `". $wpdb->posts ."` WHERE `post_status` = 'publish' AND `post_type` = 'page' " );
								?>
								<div id="<?php echo CED_WCSWR_PREFIX; ?>_page">
									<select id="page_ids" multiple="multiple" class="<?php echo CED_WCSWR_PREFIX; ?>-select2">
										<?php
										foreach ( $all_posts as $post )
										{
											if($pages_already_have_occasional_content!=null)
											{
												if(!in_array($post->ID, $pages_already_have_occasional_content ))
												{
													?>
													<option value="<?php echo $post->ID;?>"><?php echo $post->post_title;?></option>
													<?php   
												}
											}
											else
											{
												?>
												<option value="<?php echo $post->ID;?>"><?php echo $post->post_title;?></option>
												<?php			
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="<?php echo CED_WCSWR_PREFIX; ?>_occasional_content_enter <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-label"> 
									<strong> 
										<?php _e('Occasional Content:','wp-content-scheduler-with-range');?>
									</strong>
								</label>
							</div>
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">

								<?php 
								$settings = array(  'textarea_name' => 'ced_wcswr_occasional_content',
									'quicktags' => true,
									'media_buttons' => false,
									'editor_height' => 150
									);
								wp_editor( $content, 'ced_wcswr_occasional_content', $settings );
								?>
							</div>
						</div>

						<div class="<?php echo CED_WCSWR_PREFIX; ?>_content_position <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-content-postion-label"> 
									<strong> <?php _e('Content Position:','wp-content-scheduler-with-range');?>	</strong>
								</label>
							</div>

							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
								<select id="<?php echo CED_WCSWR_PREFIX; ?>_content_pos">
									<option id="top" value="Top" <?php echo $top;?>><?php _e('Top','wp-content-scheduler-with-range');?></option>
									<option id="bottom" value="Bottom" <?php echo $bottom;?>><?php _e('Bottom','wp-content-scheduler-with-range');?></option>
								</select>
							</div>
						</div>

						<div class="<?php echo CED_WCSWR_PREFIX; ?>_rendering_dates <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-dates-label"> 
									<strong>
										<?php _e('Select Display Term:','wp-content-scheduler-with-range');?>
									</strong>
								</label>
							</div>
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
								<?php $display_term_array = array(
									'date_range' => 'Select Date Range',
									'daily'      => 'Daily',
									'weekly'	 => 'Weekly',
									'monthly'    => 'Monthly',
									);
								$display_term_array = apply_filters( CED_WCSWR_PREFIX.'add_display_terms' , $display_term_array );
								?>
								<select class="<?php echo CED_WCSWR_PREFIX; ?>_display_term">
									<option value=""><?php _e('-Select-' , 'wp-content-scheduler-with-range'); ?></option>
									<?php foreach ($display_term_array as $key => $value) {
										?>									
										<option value="<?php echo $key; ?>"><?php _e( $value,'wp-content-scheduler-with-range');?></option>
										<?php
									} ?>								
								</select>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>_date_range" style="display:none;padding-top:5px;">								
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_occasion_date_pic" id="<?php echo CED_WCSWR_PREFIX; ?>_occasional_from" placeholder="Date from" value="" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_occasional_from"><img alt="close" style="left: 3px;position: relative;width: 2%;" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_occasion_date_pic" id="<?php echo CED_WCSWR_PREFIX; ?>_occasional_to" placeholder="Date to" value="" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_occasional_to"><img alt="close" style="left: 3px;position: relative;width: 2%;" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
								</div>
								<div class="ced_wcswr_weekly" style="display:none;padding-top:5px;">
									<select id="<?php echo CED_WCSWR_PREFIX; ?>_week" multiple="multiple" style="display:none;" data-placeholder="<?php _e('Select Days' , 'wp-content-scheduler-with-range'); ?>">
										<option value="sunday"><?php _e( 'Sunday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="monday"><?php _e( 'Monday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="tuesday"><?php _e( 'Tuesday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="wednesday"><?php _e( 'Wednesday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="thursday"><?php _e( 'Thursday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="friday"><?php _e( 'Friday', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="saturday"><?php _e( 'Saturday', 'wp-content-scheduler-with-range' ); ?></option>
									</select>								
								</div>
								<div class="ced_wcswr_monthly" style="display:none;padding-top:5px;">								
									<select id="<?php echo CED_WCSWR_PREFIX; ?>_month" multiple="multiple" style="display:none;" data-placeholder="<?php _e('Select Months' , 'wp-content-scheduler-with-range'); ?>" >
										<option value="january"><?php _e( 'January', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="february"><?php _e( 'February', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="march"><?php _e( 'March', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="april"><?php _e( 'April', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="may"><?php _e( 'May', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="june"><?php _e( 'June', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="july"><?php _e( 'July', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="august"><?php _e( 'August', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="september"><?php _e( 'September', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="october"><?php _e( 'October', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="november"><?php _e( 'November', 'wp-content-scheduler-with-range' ); ?></option>
										<option value="december"><?php _e( 'December', 'wp-content-scheduler-with-range' ); ?></option>
									</select>
								</div>
							</div>
						</div>

						<div class="<?php echo CED_WCSWR_PREFIX; ?>_rendering_dates <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-dates-label"> 
									<strong>
										<?php _e('Rendering Time:','wp-content-scheduler-with-range');?>
									</strong>
								</label>
							</div>
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-occasional-content-right_wrapper">
								<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_occasion_time_pic timepicker" id="<?php echo CED_WCSWR_PREFIX; ?>_occasional_time_from" placeholder="12:00 AM" value="<?php echo(!empty($occasional_contents['occasion_time_from']) ? $occasional_contents['occasion_time_from'] : '12:00 AM');?>" readonly="readonly">
								<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_occasional_time_from"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span> 
								<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_occasion_time_pic timepicker" id="<?php echo CED_WCSWR_PREFIX; ?>_occasional_time_to" placeholder="12:00 PM" value="<?php echo(!empty($occasional_contents['occasion_time_to']) ? $occasional_contents['occasion_time_to'] : '12:00 AM');?>" readonly="readonly">
								<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_occasional_time_to"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
							</div>
						</div>

						<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn">
							<button type="button" id="<?php echo CED_WCSWR_PREFIX; ?>_save_occasional_content" class="<?php echo CED_WCSWR_PREFIX; ?>_button button-primary" value=""><?php _e('Save','wp-content-scheduler-with-range');?></button>
							<img src="<?php echo CED_WCSWR_PLUGIN_URL?>/assets/images/loading.gif" class="<?php echo CED_WCSWR_PREFIX; ?>_occasional_content_loding_img">
						</div>

					</div>
				</div> <!-- tab_content3_3 ends -->



				<!--shortcode starts-->
				<div class="<?php echo CED_WCSWR_PREFIX; ?>_extra_content2 <?php echo CED_WCSWR_PREFIX; ?>_eq_div" id="<?php echo CED_WCSWR_PREFIX; ?>_tab_content4">
					<div class="<?php echo CED_WCSWR_PREFIX; ?>_select_post_type4">
						<div class="<?php echo CED_WCSWR_PREFIX; ?>_create_shortcode <?php echo CED_WCSWR_PREFIX; ?>_default">
							<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-left_wrapper">
								<label class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-label"> 
									<strong> 
										<?php _e('Shortcode:','wp-content-scheduler-with-range');
										if(!empty($shortcode_content))
										{
											?>
											<a class="wcswr_code_hint_show" title="<?php _e('To use shortcode you just need to paste the content of the grey portion in your posts','wp-content-scheduler-with-range'); ?>" href="#" id="help-prod0"><img width="16" height="16" src="<?php echo CED_WCSWR_PLUGIN_URL?>assets/images/icons.png"></a>
											<?php } ?>
										</strong>
									</label>
								</div>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-right_wrapper1">
									<textarea required="required" rows="1" cols="30" id="<?php echo CED_WCSWR_PREFIX; ?>_create_shortcode_editor" placeholder="<?php if(empty($shortcode_content)){ ?>Enter your shortcode here... <?php } ?> " ><?php if(!empty($shortcode_content)) { echo $shortcode_content['shortcode']; }?></textarea>
								</div>
								<?php if(!empty($shortcode_content))
								{ ?>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-right_wrapper2">
									<?php echo '<code>['.$shortcode_content['shortcode'].']</code>'; ?>
								</div>
								<?php	} ?>
								<?php echo '<p id="ced_wcswr_not_allowed">'.__("(Space and special characters like &,$,{},[],^,% etc. are not allowed)","wp-content-scheduler-with-range").'</p>'; ?>
							</div>

							<div class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_content_enter <?php echo CED_WCSWR_PREFIX; ?>_default">
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-left_wrapper">
									<label class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-label"> 
										<strong> 
											<?php _e('Shortcode Content:','wp-content-scheduler-with-range');?>
										</strong>
									</label>
								</div>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-right_wrapper">
									<?php
									$content= stripslashes($shortcode_content['content_to_show']);
									$settings = array(  'textarea_name' => 'ced_wcswr_shortcode_content',
										'quicktags' => true,
										'media_buttons' => false,
										'editor_height' => 150		                
										);
									wp_editor( $content, 'ced_wcswr_shortcode_content', $settings );
									?>
								</div>
							</div>

							<div class="<?php echo CED_WCSWR_PREFIX; ?>_rendering_dates <?php echo CED_WCSWR_PREFIX; ?>_default">
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-left_wrapper">
									<label class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-dates-label"> 
										<strong>
											<?php _e('Rendering Dates:','wp-content-scheduler-with-range');?>
										</strong>
									</label>
								</div>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-right_wrapper">
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_date_pic" id="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_from" placeholder="Date from" value="<?php if (!empty($shortcode_content)){echo $shortcode_content['shortcode_date_from'];}?>" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_from"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_date_pic" id="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_to" placeholder="Date to" value="<?php if (!empty($shortcode_content)){echo $shortcode_content['shortcode_date_to'];}?>" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_to"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
								</div>
							</div>

							<div class="<?php echo CED_WCSWR_PREFIX; ?>_rendering_dates <?php echo CED_WCSWR_PREFIX; ?>_default">
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-left_wrapper">
									<label class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-dates-label"> 
										<strong>
											<?php _e('Rendering Time:','wp-content-scheduler-with-range');?>
										</strong>
									</label>
								</div>
								<div class="<?php echo CED_WCSWR_PREFIX; ?>-shortcode-content-right_wrapper">
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_pic timepicker" id="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_from" placeholder="12:00 AM" value="<?php echo(!empty($shortcode_content['shortcode_time_from']) ? $shortcode_content['shortcode_time_from'] : '12:00 AM');?>" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_from"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span> 
									<input type="text" class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_pic timepicker" id="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_to" placeholder="12:00 AM" value="<?php echo(!empty($shortcode_content['shortcode_time_to']) ? $shortcode_content['shortcode_time_to'] : '12:00 AM');?>" readonly="readonly">
									<span class="<?php echo CED_WCSWR_PREFIX; ?>_clear" data-for="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_time_to"><img alt="close" src="<?php echo CED_WCSWR_PLUGIN_URL.'assets/images/cross.png';?>"></span>
								</div>
							</div>

							<div class="<?php echo CED_WCSWR_PREFIX; ?>_submit_btn">
								<button type="button" id="<?php echo CED_WCSWR_PREFIX; ?>_save_shortcode_content" class="<?php echo CED_WCSWR_PREFIX; ?>_button button-primary" value=""><?php _e('Save','wp-content-scheduler-with-range');?></button>
								<img src="<?php echo CED_WCSWR_PLUGIN_URL?>/assets/images/loading.gif" class="<?php echo CED_WCSWR_PREFIX; ?>_shortcode_loding_img">
							</div>

						</div>
					</div> <!--shortcode ends-->
				</div>
			</div>
				<!-- side-bar advertisement code start here  -->

	<?php  
	if(!session_id())
		session_start();
	if(!isset($_SESSION["ced_wcswr_hide_email"])):	
		$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$urlvars = parse_url($actual_link);
	$url_params = $urlvars["query"];
	?>
	<div class="ced_wcswr_img_email_image">
		<div class="ced_wcswr_email_main_content">
			<div class="ced_wcswr_cross_image">
				<a class="button-primary ced_wcswr_cross_image_link" href="?<?php echo $url_params?>&ced_wcswr_close=true">x</a>
			</div>
			<div class="ced-recom">
				<h4>Cedcommerce recommendations for you </h4>
			</div>
			<div class="wramvp_main_content__col">
				<p> 
					Looking forward to evolve your eCommerce?
					<a href="http://bit.ly/2LB1lZV" target="_blank">Sell on the TOP Marketplaces</a>
				</p>
				<div class="wramvp_img_banner">
					<a target="_blank" href="http://bit.ly/2LB1lZV"><img alt="market-place" src="<?php echo plugins_url().'/wp-content-scheduler-with-range/assets/images/market-place-2.jpg'?>"></a> 
				</div>
			</div>
			<br>
			<div class="wramvp_main_content__col">
				<p> 
					Leverage auto-syncing centralized order management and more with our
					<a href="http://bit.ly/2LB71TJ" target="_blank">Integration Extensions</a> 
				</p>
				<div class="wramvp_img_banner">
					<a target="_blank" href="http://bit.ly/2LB71TJ"><img alt="market-place" src="<?php echo plugins_url().'/wp-content-scheduler-with-range/assets/images/market-place.jpg'?>"></a> 
				</div>
			</div>
			<div class="wramvp-support">
				<ul>
					<li>
						<span class="wramvp-support__left">Contact Us :-</span>
						<span class="wramvp-support__right"><a href="mailto:support@cedcommerce.com"> support@cedcommerce.com </a></span>
					</li>
					<li>
						<span class="wramvp-support__left">Get expert's advice :-</span>
						<span class="wramvp-support__right"><a href="https://join.skype.com/bovbEZQAR4DC"> Join Us</a></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>

<!-- side-bar advertisement code  ends start here  -->



			