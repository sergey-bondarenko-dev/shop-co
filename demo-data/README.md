# WooCommerce demo products

This folder contains a generated CSV import for local WooCommerce catalog testing.

## Files

- `woocommerce-demo-products.csv` - ready-to-import WooCommerce product CSV.
- `generate-woocommerce-demo-products.php` - generator used to rebuild the CSV.

## What is included

- 100 visible demo products.
- Several variable products with color and size variations.
- Categories for Men, Women, Unisex, T-shirts, Shirts, Shorts, Jeans, Hoodie, Polos, Jackets, and Sweaters.
- Dress style attributes: Casual, Formal, Party, Gym.
- Color and size attributes for filter testing.
- Sale prices, regular prices, featured products, out-of-stock products, and backorder scenarios.
- Placeholder product images from `placehold.co`; WooCommerce downloads them into the Media Library during import if the WordPress container has internet access.
- Demo-only metadata fields: `_demo_rating` and `_demo_review_count`.

## Import

In WordPress admin:

1. Go to `Products -> All Products -> Import`.
2. Upload `demo-data/woocommerce-demo-products.csv`.
3. Keep the automatic column mapping.
4. Run the importer.

If a previous import failed, delete the partially imported demo products first.
The easiest way is to search products by the `demo-` SKU prefix in WordPress admin and move them to trash before importing again.

To regenerate the CSV:

```bash
php demo-data/generate-woocommerce-demo-products.php
```
