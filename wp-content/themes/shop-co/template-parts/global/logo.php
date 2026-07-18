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

$shop_co_args = wp_parse_args(
	$args,
	array(
		'class' => '',
	)
);

$shop_co_extra_classes = array_filter( array_map( 'sanitize_html_class', preg_split( '/\s+/', (string) $shop_co_args['class'] ) ) );
$shop_co_class         = trim( 'site-logo ' . implode( ' ', $shop_co_extra_classes ) );
?>

<div class="<?php echo esc_attr( $shop_co_class ); ?>">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a class="site-logo__fallback" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>
	<?php endif; ?>
</div>
