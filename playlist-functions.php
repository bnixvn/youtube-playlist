<?php
function youtube_id($url) {
    $videoId = null;
    $regExp = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:shorts\/|watch\?v=))([a-zA-Z0-9_-]{11})/';
    preg_match($regExp, $url, $matches);
    if (!empty($matches[1])) {
        $videoId = $matches[1];
    }
    return $videoId;
}
//Code youtube play list
add_shortcode('bnix_play','youtube_list');
function youtube_list() {
	$enable = get_field('enable_playlist','option');
	$videos = get_field('video_playlist','option');
	if($videos && $enable == true) {
		ob_start();
		?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/youtube.css" />
		<div class="row row-small">
			<div class="col medium-12">
				<div class="col-inner video-gallery-container" style="background-color: <?php echo get_field('video_list_border','option'); ?>;">
					<div class="video-gallery" style="background-color: <?php echo get_field('video_list_bg','option'); ?>;">
						<div class="featured-video">
							<div class="responsive-iframe">				
								<iframe
										width="560"
										height="315"
										src="https://www.youtube.com/embed/<?php echo youtube_id($videos[0]['video_link']); ?>?rel=0&autoplay=1&mute=1&loop=1"
										title="<?php echo $videos[0]['video_name']; ?>"
										frameborder="0"
										allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
										allowfullscreen
										></iframe>
							</div>
							<h3 class="video-title">
								<?php echo $videos[0]['video_name']; ?>
							</h3>
						</div>
						<div class="all-videos">
							<?php foreach($videos as $video) { ?>
							<div class="video-box">				
								<div class="video">
									<img
										 class="thumbnail"
										 data-id="<?php echo youtube_id($video['video_link']); ?>"
										 data-title="<?php echo $video['video_name']; ?>"
										 src="https://img.youtube.com/vi/<?php echo youtube_id($video['video_link']); ?>/maxresdefault.jpg"
										 alt="<?php echo $video['video_name']; ?>"
										 />
									<div class="play-icon">
										<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/play-icon.png" alt="Video Play Icon" />
									</div>
								</div>
								<div class="video-content">
									<h3 class="video-title">
										<?php echo $video['video_name']; ?>
									</h3>
									<p>
										<?php echo $video['video_des']; ?>
									</p>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/js/youtube.js'></script>
		<?php
		$play = ob_get_contents();
		ob_end_clean();
		return $play;
	}
}
