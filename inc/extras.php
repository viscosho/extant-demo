<?php
/**
 * Extant Demo functions and definitions - Integrations - Extras
 *
 * @package    ExtantDemo
 * @subpackage extras
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A shortcode for the slider
 *
 * @param [type] $atts
 * @return void
 */
function extant_bxslider_shortcode( $atts ) {
	?>
	<div class="slider">
		<div class="banner">
			<div class="container">
				<div class="header-text">
					<p class="big-text">Let's Start The Web Journey</p>
					<h2>Extant Your Creative Thoughts</h2>
					<p class="small-text">Extant is a free html5 template designed by <a href="www.html5layouts.com">HTML5 Layouts</a> and released under common creative licence 3.0</p>
					<div class="button-section">
						<ul>
							<li><a href="#" class="top-button white">Learn More</a></li>
							<li><a href="#" class="top-button green">Get Started</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- <div><img src="assets/img/picjumbo-bg5.png" title="Funky roots"></div>
		<div><img src="/assets/img/picjumbo-bg5.png" title="The long and winding road"></div>
		<div><img src="/assets/img/picjumbo-bg5.png" title="Happy trees"></div> -->
	</div>
	<div class="color-border"></div>
	<?php
}
add_shortcode( 'extant_bxslider', 'extant_bxslider_shortcode' );