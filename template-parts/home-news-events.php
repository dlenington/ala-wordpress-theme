<?php

$settings = array(
	'cat' => 12,
	'title'  => 'Announcements',
);
	$newsFirstRow = education_hub_get_home_news_block_content(null);
	$eventsFirstRow = education_hub_get_home_events_block_content(null);
	$newsSecondRow = education_hub_get_home_news_block_content_row2($settings);
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
<?php if ( $newsSecondRow || $eventsFirstRow ) : ?>
	<div id="featured-news-events">
		<div class="container">
			<div class="inner-wrapper">
				
				<?php echo $newsSecondRow; ?>
			</div> <!-- .inner-wrapper -->
		</div> <!-- .container -->
	</div> <!-- #featured-news-events -->
<?php endif ?>
