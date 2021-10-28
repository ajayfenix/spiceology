<?php
/**
 * This is the file for the _____recipes-carousel_____ ACF block type
 *
 * @example https://www.advancedcustomfields.com/resources/acf_register_block_type/#examples
 * 
 * @example https://www.youtube.com/watch?v=s6qomMzP0BU How to make a ACF Block Type
 *
 * @package Coalition_Technologies
 */


// Must include for ct_block_init to work!!
global $ctblock;
$ctblock = $block;

$testimonial_query = array(
	'posts_per_page'	=> -1,
	'order'				=> 'ASC',
	'orderby'			=> 'title',
  'post_type'		=> 'testimonials',
);

$testimonial_query = new WP_Query( $testimonial_query );

?>

<div <?php ct_block_init( 'testimonial-block' ); ?>>
	
	<div class="text-container">
		<?php
			if ( !empty( get_field( 'primary_heading' ) ) ) :
				echo '<h4 class="h6 underlined upper">' . get_field( 'primary_heading' ) . '</h4>';
			endif;

			if ( !empty( get_field( 'sub_heading' ) ) ) :
				echo '<h2>' . get_field( 'sub_heading' ) . '</h2>';
			endif;
		?>
    
	</div>

  <?php if( $testimonial_query->have_posts() ) : ?>
    <div class="testimonial-slider">
      <?php while( $testimonial_query->have_posts() ) : $testimonial_query->the_post(); 

        include locate_template( 'partials/testimonial-card.php' );
      
      ?>
        
      <?php endwhile; ?>
    </div>

  <?php endif; ?>

</div>
