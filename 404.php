<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
    <style>
        #bar-nav{
            box-shadow:inherit;
            border-bottom:1px solid rgba(0,0,0,0.5);
        }
    </style>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not Found', 'twentythirteen' ); ?></h1>
			</header>

			<div class="page-wrapper container mt-5 pt-5">
				<div class="d-flex flex-column align-items-center">
					<h2><?php _e( 'No hemos conseguido lo que está buscando', 'twentythirteen' ); ?></h2>
					<p><?php _e( '¿Ha comprobado si necesita iniciar sesión?', 'twentythirteen' ); ?></p>
                    <div class="d-flex flex-wrap">
                        <div class="btn-link-see mr-4 ml-4">
                            <a href="/mi-cuenta/" class="btn-a btn-e mb-4 pl-4 pr-4" style="border:1px solid black;max-width:250px;">Iniciar sesión</a>
                        </div>
                        <div class="btn-link-see mr-4 ml-4">
                            <a href="/" class="btn-a btn-e mb-4 pl-4 pr-4" style="border:1px solid black;max-width:250px;">Ir al inicio</a>
                        </div>
                    </div>
				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>