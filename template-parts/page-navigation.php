<?php
/**
 * Template part for displaying page navigation links.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Judge_Familiar
 */

?>

<div class="page-navigation">
  <?php foreach ( array('_previous_page', '_next_page') as $element ) {
    $id = get_post_meta( get_the_ID(), $element, true );
    $title = get_post_meta( get_the_ID(), $element . '_title', true );

    if ( $id && get_post_status ( $id ) == 'publish' ) {
      printf(
        '<a class="%s" href="%s">%s</a>',
        $element,
        get_permalink( $id ),
        ( empty( $title ) ? get_the_title( $id ) : $title )
      );
    }
  } ?>
</div>
