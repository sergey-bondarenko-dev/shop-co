# Demo data

This folder contains generated demo imports for local Shop Co testing.

## Files

- `woocommerce-demo-products.csv` - ready-to-import WooCommerce product CSV.
- `generate-woocommerce-demo-products.php` - generator used to rebuild the CSV.
- `testimonials.xml` - WordPress WXR import with demo testimonials.

## WooCommerce products

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

## Testimonials

In WordPress admin:

1. Go to `Tools -> Import`.
2. Install or run the `WordPress` importer.
3. Make sure the `Shop Co Core` plugin is active.
4. Upload `demo-data/testimonials.xml`.
5. Assign imported posts to an existing user.
6. Run the importer.

The import creates published `testimonial` posts. The post title is the reviewer name, the post content is the testimonial text, and `menu_order` controls display order.
