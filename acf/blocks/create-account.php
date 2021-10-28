<?php
/**
 * This is the file for the _____create-account_____ ACF block type
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

?>

<div <?php ct_block_init( 'create-account' ); ?>>

	<div class="container">
		<div class="row">
			<div class="text-with-icon">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 45"><path d="M28.414 27c5.684 0 10.322 4.824 10.575 10.878L39 38.4v4.8c0 .994-.748 1.8-1.671 1.8-.847 0-1.546-.677-1.657-1.556l-.015-.244v-4.8c0-4.16-3.023-7.558-6.832-7.788l-.41-.012h-17.83c-3.861 0-7.018 3.255-7.23 7.357l-.012.443v4.8c0 .994-.748 1.8-1.672 1.8-.846 0-1.545-.677-1.656-1.556L0 43.2v-4.8c0-6.121 4.48-11.116 10.101-11.388l.485-.012h17.828zM19.5 0C25.299 0 30 5.149 30 11.5S25.299 23 19.5 23C12.332 23 9 19.35 9 11.5 9 5.149 13.701 0 19.5 0zm0 3.632c-3.968 0-7.184 3.522-7.184 7.868 0 5.845 1.847 7.868 7.184 7.868 3.968 0 7.184-3.522 7.184-7.868S23.468 3.632 19.5 3.632z" fill="#FEA536"/></svg>
				<div class="text">
					<h4 class="sub-text">Spiceology.com</h4>
					<h3 class="main">Accounts</h3>
				</div>
			</div>

			<?php if ( have_rows( 'key_items' )  ):
				while ( have_rows( 'key_items' ) ) : the_row();

					echo '<div class="item-container"><div class="item">' . get_sub_field( 'item' ) . '</div></div>';

				endwhile;
			endif; ?>

			<?php
				if ( get_field( 'button' ) ) {
					$link_url = get_field( 'button' )['url'];
					$link_title = get_field( 'button' )['title'];
					$link_target = get_field( 'button' )['target'] ? get_field( 'button' )['target'] : '_self';

					echo "<a class='btn btn-main' href='{$link_url}' target='{$link_target}'>{$link_title}</a>";
				}
			?>
		</div>
	</div>

</div>
