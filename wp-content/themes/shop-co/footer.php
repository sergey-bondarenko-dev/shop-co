<?php
/**
 * Site footer.
 *
 * @package Shop_Co
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="container site-footer__inner">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
			<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'shop-co' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		</div>
	</footer>
</div>

<?php wp_footer(); ?>
</body>
</html>
