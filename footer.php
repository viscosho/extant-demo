<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ExtantDemo
 */

?>
	<div class="color-border"></div>
	<footer id="colophon" class="site-footer footer">
		<div class="container">
            	<div class="infooter">
				<p class="copyright">
					<?php
					printf(
						/* Translators: 1: year */
						esc_html__( 'Copyright © Extant %1$s', 'extant-demo' ),
						extant_current_year()
					);
					?>
					</p>
            	</div>
            <ul class="socialmedia">
                <li><a href=""><i class="icon-twitter"></i></a></li>
                <li><a href=""><i class="icon-facebook"></i></a></li>
                <li><a href=""><i class="icon-dribbble"></i></a></li>
                <li><a href=""><i class="icon-linkedin"></i></a></li>
                <li><a href=""><i class="icon-instagram"></i></a></li>
            </ul>
            </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
