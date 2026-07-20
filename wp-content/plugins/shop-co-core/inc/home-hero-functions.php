<?php
/**
 * Home page hero public functions.
 *
 * @package Shop_Co_Core
 */

/**
 * Get editable home page hero data.
 *
 * @return array<string, mixed>
 */
function shop_co_core_get_home_hero(): array {
	return Shop_Co_Core_Home_Hero::get_data();
}
