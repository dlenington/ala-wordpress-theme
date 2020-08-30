<?php
	$news = education_hub_get_home_news_block_content();
	$news2 = education_hub_get_home_news_block_content_2();
	$events = education_hub_get_home_events_block_content();
	
?>
<?php if ( $news || $events ) : ?>
	<div id="featured-news-events">
		<div class="container">
			<div class="inner-wrapper">
				<?php echo $news2; ?>
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
<?php if ( $news || $events ) : ?>
	<div id="featured-news-events">
		<div class="container">
			<div class="inner-wrapper">
				<?php echo $news; ?>
				<?php echo $events; ?>
			</div> <!-- .inner-wrapper -->
		</div> <!-- .container -->
	</div> <!-- #featured-news-events -->
<?php endif ?>