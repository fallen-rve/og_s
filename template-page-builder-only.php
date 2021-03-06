<?php
/**
 * Template Name: Page Builder Only
 *
 * @package og_s
 */

get_header(); ?>

	<div class="wrap">

		<div class="primary content-area">
			<main class="site-main">

				<?php wds_page_builder_load_parts(); ?>

			</main><!-- #main -->
		</div><!-- .primary -->

	</div><!-- .wrap -->

<?php get_footer(); ?>
