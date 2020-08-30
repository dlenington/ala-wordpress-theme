<?php

$settings = array(
	'cat' => 12,
	'title'  => 'Announcements',
);
	$newsFirstRow = education_hub_get_home_news_block_content(null);
	$eventsFirstRow = education_hub_get_home_events_block_content(null);
	$newsSecondRow = education_hub_get_home_news_block_content_row2();
?>
<?php if ( $newsSecondRow ) : ?>
	<div id="featured-news-events">
		<div class="container">
			<div class="inner-wrapper">
				
				<?php echo $newsSecondRow; ?>
			</div> <!-- .inner-wrapper -->
		</div> <!-- .container -->
	</div> <!-- #featured-news-events -->
<?php endif ?>
<?php
	/**
	 * Hook - education_hub_action_before_content.
	 *
	 * @hooked education_hub_add_breadcrumb - 7
	 * @hooked education_hub_content_start - 10
	 */
	do_action( 'education_hub_action_featured_content' );
	?>
<?php if ( $newsFirstRow || $eventsFirstRow ) : ?>
	<div id="featured-news-events">
		<div class="container">
			<div class="inner-wrapper">
				<?php echo $newsFirstRow; ?>
				<?php echo $eventsFirstRow; ?>
			</div> <!-- .inner-wrapper -->
		</div> <!-- .container -->
	</div> <!-- #featured-news-events -->
<?php endif ?>

