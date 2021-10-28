<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Coalition_Technologies
 */

get_header();

?>

	<section class="error-404 not-found">
		<center>
			<header class="page-header">
				<h1 class="page-title"><?= get_field( '404_title', 'option' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				
				<p><?= get_field( '404_message', 'option' ); ?></p>

				<form role="search" method="get" class="search-form" action="<?= get_site_url(); ?>">
				<div class="field-group">
					<label>
						<input type="search" class="search-field" placeholder="Search …" value="" name="s" data-swplive="true" data-swpengine="default" data-swpconfig="default" autocomplete="off" aria-autocomplete="both" style="width: 100%;line-height: 29px; display: inline-block; margin-bottom: 10px;">
					</label>
					<input type="submit" class="search-submit btn btn-main" value="Search" style="width: 100%;">
				</div>
			</form>

			</div><!-- .page-content -->
		</center>
	</section><!-- .error-404 -->

	<style>
		.error-404 {
			min-height: 50vh;
			display: -webkit-box;
			display: -webkit-flex;
			display: -moz-box;
			display: -ms-flexbox;
			display: flex;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-moz-box-pack: center;
			-ms-flex-pack: center;
			justify-content: center;
			-webkit-box-align: center;
			-webkit-align-items: center;
			-moz-box-align: center;
			-ms-flex-align: center;
			align-items: center;
		}
	</style>

<?php
get_footer();
