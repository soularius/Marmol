<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
      <div id="page-struct" class="container-fluid pt-4 pb-5 d-flex justify-content-center flex-column pl-0 pr-0" style="margin:auto;">
        <?php
        while ( have_posts() ) :
          the_post();

          do_action( 'storefront_page_before' );

          get_template_part( 'content', 'page' );

          /**
           * Functions hooked in to storefront_page_after action
           *
           * @hooked storefront_display_comments - 10
           */
          do_action( 'storefront_page_after' );

        endwhile; // End of the loop.
        ?>
      </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
