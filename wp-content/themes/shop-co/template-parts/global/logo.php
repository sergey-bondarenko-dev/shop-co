<?php
/**
 * Site logo template part.
 *
 * @package Shop_Co
 *
 * @var array $args Template arguments.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args,
	array(
		'class' => '',
	)
);

$extra_classes = array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', (string) $args['class'] ) ) );
$class         = trim( 'site-logo ' . implode( ' ', $extra_classes ) );
?>

<div class="<?php echo esc_attr( $class ); ?>">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="site-logo__fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>
	<?php endif; ?>
</div>
