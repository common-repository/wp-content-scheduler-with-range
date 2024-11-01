<?php
if (! defined ( 'ABSPATH' )) 
{
	exit (); // Exit if accessed directly
}
$flag=0;
?>
<?php if($_SESSION["ced_wcswr_hide_email"]==true){	?>
<div class="<?php echo CED_WCSWR_PREFIX; ?>_container ced-page2-container ced-full-width"> <!--end's at last of page-->
	<?php } ?>
	<div class="<?php echo CED_WCSWR_PREFIX; ?>_container ced-page2-container">
	<h2 class="<?php echo CED_WCSWR_PREFIX; ?>_setting_wrapper"><?php _e('Scheduled Posts', 'wp-content-scheduler-with-range');?></h2>
	
	<p class="wcswr-search-box">
		<label class="screen-reader-text" for="post-search-input">Search Scheduled Posts:</label>
		<input type="search" id="wcswr-post-search-input" value="" placeholder="Search">
	</p>
	<table class="wp-list-table widefat fixed striped posts" id="scheduled_posts_table">
		<thead>
			<tr>
				<th id="title"><?php _e('Title','wp-content-scheduler-with-range'); ?></th>

				<th id="rendering-dates"><?php _e('Rendering Dates','wp-content-scheduler-with-range'); ?></th>

				<th id="rendering-time"><?php _e('Rendering Time','wp-content-scheduler-with-range'); ?></th>

			</tr>
		</thead>

		<tbody id="the-list">
			<?php
			$args = array(
				'post_status' 	 => 'publish',
				'post_type'   	 => array( 'any' ),
				'meta_key'	  	 => 'ced_wcswr_from_date',
				'posts_per_page' => '-1'
				);

			$query = new WP_Query($args);

			if($query->have_posts())
			{
				while($query->have_posts())
				{
					$query->the_post();
					$get_from_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_from_date', true );
					$get_to_date=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_to_date', true );
					$get_from_time=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_from_time', true );
					$get_to_time=get_post_meta ( get_the_ID(), CED_WCSWR_PREFIX . '_to_time', true );
					if($get_from_date!=null &&  $get_to_date!=null)
					{ 
						$flag=1;
						?>
						<tr id="wcswr-scheduled-post-<?php echo get_the_ID();?>" class="wcswr-scheduled-post" data-title="<?php echo strtolower( get_the_title() ); ?>">
							<td  data-colname="Title" class="title column-title has-row-actions column-primary page-title">
								<strong>
									<?php echo get_the_title(get_the_ID()); ?>	
								</strong>


								<div class="row-actions">

									<span class="edit">
										<a aria-label="" href="<?php echo get_edit_post_link(); ?>"><?php _e('Edit','wp-content-scheduler-with-range'); ?></a>
									</span>

								</div>
							</td><!--content-->

							<td data-colname="Rendering Date" class="rendering-date">
								<?php echo '<p>' . $get_from_date . ' to</p>'; ?>
								<?php echo $get_to_date; ?>
							</td><!--rendering dates-->


							<td data-colname="Rendering Time" class="rendering-time">
								<?php echo '<p>' . $get_from_time . ' to</p>' ; ?>
								<?php echo $get_to_time ?>	
							</td><!--rendering time-->
						</tr>
						<?php 			
					}
				}
			}

			if($flag==0)
			{
				?>
				<tr>
					<td id="no_schedueled_posts" rowspan="3" colspan="3"><?php _e('No Content To Show. Schedule Some Posts/Pages First.','wp-content-scheduler-with-range'); ?></td>
				</tr>

				<?php
			}			
			?>
		</tbody>
	</table>
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
			</div><br>
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
<div>
	<!-- side-bar advertisement code  ends start here  -->

</div>
	
