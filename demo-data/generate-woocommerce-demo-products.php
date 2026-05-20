<?php

declare(strict_types=1);

$outputFile = __DIR__ . '/woocommerce-demo-products.csv';

$headers = [
    'Type',
    'SKU',
    'Name',
    'Published',
    'Is featured?',
    'Visibility in catalog',
    'Short description',
    'Description',
    'Tax status',
    'In stock?',
    'Stock',
    'Backorders allowed?',
    'Sold individually?',
    'Allow customer reviews?',
    'Sale price',
    'Regular price',
    'Categories',
    'Tags',
    'Images',
    'Parent',
    'Position',
    'Attribute 1 name',
    'Attribute 1 value(s)',
    'Attribute 1 visible',
    'Attribute 1 global',
    'Attribute 1 default',
    'Attribute 2 name',
    'Attribute 2 value(s)',
    'Attribute 2 visible',
    'Attribute 2 global',
    'Attribute 2 default',
    'Attribute 3 name',
    'Attribute 3 value(s)',
    'Attribute 3 visible',
    'Attribute 3 global',
    'Attribute 3 default',
    'Meta: _demo_rating',
    'Meta: _demo_review_count',
];

$seedProducts = [
    ['Gradient Graphic T-shirt', 'T-shirts', 'Casual', 145, null, ['White', 'Pink', 'Blue'], ['Small', 'Medium', 'Large'], 3.5],
    ['Polo with Tipping Details', 'T-shirts', 'Casual', 180, null, ['Burgundy', 'Navy'], ['Medium', 'Large', 'X-Large'], 4.5],
    ['Black Striped T-shirt', 'T-shirts', 'Casual', 150, 120, ['Black', 'White'], ['Small', 'Medium', 'Large'], 5.0],
    ['Skinny Fit Jeans', 'Jeans', 'Casual', 260, 240, ['Blue', 'Navy'], ['Small', 'Medium', 'Large'], 3.5],
    ['Checkered Shirt', 'Shirts', 'Casual', 180, null, ['Red', 'Navy'], ['Medium', 'Large'], 4.5],
    ['Sleeve Striped T-shirt', 'T-shirts', 'Casual', 160, 130, ['Orange', 'Black'], ['Small', 'Medium', 'Large'], 4.5],
    ['Vertical Striped Shirt', 'Shirts', 'Casual', 232, 212, ['Green', 'White'], ['Medium', 'Large', 'X-Large'], 5.0],
    ['Courage Graphic T-shirt', 'T-shirts', 'Casual', 145, null, ['Orange', 'Blue'], ['Small', 'Medium', 'Large'], 4.0],
    ['Loose Fit Bermuda Shorts', 'Shorts', 'Casual', 80, null, ['Blue'], ['Small', 'Medium', 'Large'], 3.0],
    ['One Life Graphic T-shirt', 'T-shirts', 'Casual', 300, 260, ['Olive', 'Green', 'Navy'], ['Small', 'Medium', 'Large', 'X-Large'], 4.5],
];

$namesByCategory = [
    'T-shirts' => [
        'Essential Crew T-shirt',
        'Vintage Wash T-shirt',
        'Minimal Logo T-shirt',
        'Oversized Cotton T-shirt',
        'Ribbed Neck T-shirt',
        'Sunset Graphic T-shirt',
        'Heavyweight Boxy T-shirt',
        'Longline T-shirt',
        'Pocket Detail T-shirt',
        'Relaxed Fit T-shirt',
        'Contrast Collar T-shirt',
        'Washed Black T-shirt',
        'Sport Stripe T-shirt',
        'Abstract Print T-shirt',
    ],
    'Shirts' => [
        'Oxford Button Down Shirt',
        'Linen Blend Shirt',
        'Denim Overshirt',
        'Camp Collar Shirt',
        'Slim Fit Poplin Shirt',
        'Textured Resort Shirt',
        'Plaid Flannel Shirt',
        'Mandarin Collar Shirt',
        'Chambray Work Shirt',
        'Premium Twill Shirt',
        'Micro Pattern Shirt',
        'Utility Pocket Shirt',
    ],
    'Shorts' => [
        'Tailored Chino Shorts',
        'Cargo Utility Shorts',
        'Drawstring Jersey Shorts',
        'Swim Ready Shorts',
        'Pleated Cotton Shorts',
        'Relaxed Denim Shorts',
        'Performance Training Shorts',
        'Washed Twill Shorts',
        'Lightweight Travel Shorts',
        'Everyday Sweat Shorts',
    ],
    'Jeans' => [
        'Straight Leg Jeans',
        'Loose Fit Washed Jeans',
        'Tapered Raw Denim Jeans',
        'Relaxed Carpenter Jeans',
        'Slim Stretch Jeans',
        'Distressed Blue Jeans',
        'Black Rinse Jeans',
        'Vintage Stonewash Jeans',
        'Wide Leg Denim Jeans',
        'Utility Denim Jeans',
    ],
    'Hoodie' => [
        'Classic Pullover Hoodie',
        'Zip Through Hoodie',
        'Oversized Fleece Hoodie',
        'Washed Graphic Hoodie',
        'Heavyweight Studio Hoodie',
        'Athletic Tech Hoodie',
        'Minimal Badge Hoodie',
        'Raglan Sleeve Hoodie',
        'Thermal Lined Hoodie',
    ],
    'Polos' => [
        'Textured Knit Polo',
        'Classic Pique Polo',
        'Premium Mercerized Polo',
        'Open Collar Polo',
        'Resort Stripe Polo',
        'Contrast Sleeve Polo',
        'Performance Golf Polo',
        'Soft Touch Polo',
    ],
    'Jackets' => [
        'Lightweight Bomber Jacket',
        'Cotton Coach Jacket',
        'Utility Field Jacket',
        'Denim Trucker Jacket',
        'Quilted Overshirt Jacket',
        'Water Resistant Shell Jacket',
        'Cropped Harrington Jacket',
    ],
    'Sweaters' => [
        'Fine Knit Crew Sweater',
        'Ribbed Cardigan Sweater',
        'Chunky Cable Sweater',
        'Quarter Zip Sweater',
        'Merino Blend Sweater',
        'Relaxed V-neck Sweater',
    ],
];

$styles = ['Casual', 'Formal', 'Party', 'Gym'];
$colors = ['Black', 'White', 'Grey', 'Navy', 'Blue', 'Green', 'Olive', 'Red', 'Burgundy', 'Orange', 'Yellow', 'Purple', 'Pink'];
$sizes = ['XX-Small', 'X-Small', 'Small', 'Medium', 'Large', 'X-Large', 'XX-Large', '3X-Large', '4X-Large'];
$categoryAudience = ['Men', 'Women', 'Unisex'];
$tagsByCategory = [
    'T-shirts' => ['graphic', 'cotton', 'summer'],
    'Shirts' => ['button-down', 'smart-casual', 'layering'],
    'Shorts' => ['summer', 'travel', 'relaxed'],
    'Jeans' => ['denim', 'everyday', 'streetwear'],
    'Hoodie' => ['fleece', 'streetwear', 'layering'],
    'Polos' => ['smart-casual', 'pique', 'weekend'],
    'Jackets' => ['outerwear', 'layering', 'transitional'],
    'Sweaters' => ['knitwear', 'layering', 'winter'],
];

function slugify(string $value): string
{
    $value = strtolower($value);
    $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? $value;

    return trim($value, '-');
}

function placeholderImages(string $name, int $count, string $baseColor = 'f2f0ef'): string
{
    $labels = ['Front', 'Back', 'Detail', 'Model'];
    $images = [];

    for ($i = 0; $i < $count; $i++) {
        $label = $count === 1 ? $name : $name . ' ' . $labels[$i];
        $images[] = sprintf(
            'https://placehold.co/800x800/%s/111111.png?text=%s',
            $baseColor,
            rawurlencode($label)
        );
    }

    return implode(', ', $images);
}

function productDescription(string $name, string $category, string $style): string
{
    return sprintf(
        '%s for %s outfits. Demo product with realistic pricing, attributes, stock state, categories, tags, and placeholder imagery for WooCommerce catalog testing.',
        $name,
        strtolower($style)
    );
}

function row(array $values): array
{
    global $headers;

    return array_map(static fn (string $header): string => (string) ($values[$header] ?? ''), $headers);
}

function productRow(
    string $type,
    string $sku,
    string $name,
    string $category,
    string $style,
    string $audience,
    float $regularPrice,
    ?float $salePrice,
    array $colors,
    array $sizes,
    float $rating,
    int $stock,
    bool $featured,
    bool $backorders,
    int $imageCount,
    array $tags,
    string $parent = '',
    string $visibility = 'visible',
    int $position = 0
): array {
    $isVariation = $type === 'variation';
    $inStock = $stock > 0 || $backorders;
    $categories = $isVariation ? '' : sprintf('Shop > %s > %s, %s', $audience, $category, $style);
    $baseColors = ['f2f0ef', 'ece9e4', 'edf1ef', 'f1ecec', 'eceff3'];

    return row([
        'Type' => $type,
        'SKU' => $sku,
        'Name' => $name,
        'Published' => '1',
        'Is featured?' => $featured ? '1' : '0',
        'Visibility in catalog' => $visibility,
        'Short description' => $isVariation ? '' : productDescription($name, $category, $style),
        'Description' => $isVariation ? '' : productDescription($name, $category, $style) . ' Use this item to verify product cards, filters, sale badges, stock states, and product detail layouts.',
        'Tax status' => 'taxable',
        'In stock?' => $inStock ? '1' : '0',
        'Stock' => (string) $stock,
        'Backorders allowed?' => $backorders ? 'notify' : '0',
        'Sold individually?' => '0',
        'Allow customer reviews?' => '1',
        'Sale price' => $salePrice === null ? '' : (string) $salePrice,
        'Regular price' => (string) $regularPrice,
        'Categories' => $categories,
        'Tags' => implode(', ', array_unique(array_merge($tags, [strtolower($style), strtolower($audience)]))),
        'Images' => $isVariation ? '' : placeholderImages($name, $imageCount, $baseColors[$position % count($baseColors)]),
        'Parent' => $parent,
        'Position' => (string) $position,
        'Attribute 1 name' => 'Color',
        'Attribute 1 value(s)' => implode(', ', $colors),
        'Attribute 1 visible' => $isVariation ? '0' : '1',
        'Attribute 1 global' => '1',
        'Attribute 1 default' => $colors[0] ?? '',
        'Attribute 2 name' => 'Size',
        'Attribute 2 value(s)' => implode(', ', $sizes),
        'Attribute 2 visible' => $isVariation ? '0' : '1',
        'Attribute 2 global' => '1',
        'Attribute 2 default' => in_array('Large', $sizes, true) ? 'Large' : ($sizes[0] ?? ''),
        'Attribute 3 name' => 'Dress Style',
        'Attribute 3 value(s)' => $style,
        'Attribute 3 visible' => $isVariation ? '0' : '1',
        'Attribute 3 global' => '1',
        'Attribute 3 default' => $style,
        'Meta: _demo_rating' => (string) $rating,
        'Meta: _demo_review_count' => (string) max(0, (int) round($rating * 17) + ($position % 23)),
    ]);
}

$rows = [];
$visibleCount = 0;
$variableProductNames = [
    'One Life Graphic T-shirt',
    'Essential Crew T-shirt',
    'Classic Pullover Hoodie',
    'Straight Leg Jeans',
    'Textured Knit Polo',
    'Lightweight Bomber Jacket',
];

foreach ($seedProducts as $index => [$name, $category, $style, $regular, $sale, $productColors, $productSizes, $rating]) {
    $visibleCount++;
    $sku = 'demo-' . str_pad((string) $visibleCount, 3, '0', STR_PAD_LEFT) . '-' . slugify($name);
    $audience = $index % 4 === 0 ? 'Unisex' : 'Men';
    $type = in_array($name, $variableProductNames, true) ? 'variable' : 'simple';
    $rows[] = productRow($type, $sku, $name, $category, $style, $audience, (float) $regular, $sale === null ? null : (float) $sale, $productColors, $productSizes, (float) $rating, 20 + $index, $index % 5 === 0, false, $name === 'One Life Graphic T-shirt' ? 4 : ($index % 3 === 0 ? 3 : 1), $tagsByCategory[$category] ?? [], '', 'visible', $visibleCount);

    if ($type === 'variable') {
        foreach (array_slice($productColors, 0, 2) as $colorIndex => $color) {
            foreach (array_slice($productSizes, 0, 2) as $sizeIndex => $size) {
                $rows[] = productRow('variation', $sku . '-var-' . slugify($color) . '-' . slugify($size), $name . ' - ' . $color . ' / ' . $size, $category, $style, $audience, (float) $regular, $sale === null ? null : (float) $sale, [$color], [$size], (float) $rating, 4 + $colorIndex + $sizeIndex, false, false, 0, [], $sku, 'hidden', $sizeIndex + $colorIndex);
            }
        }
    }
}

foreach ($namesByCategory as $category => $names) {
    foreach ($names as $name) {
        if ($visibleCount >= 100) {
            break 2;
        }

        $visibleCount++;
        $style = $styles[$visibleCount % count($styles)];
        $audience = $categoryAudience[$visibleCount % count($categoryAudience)];
        $regular = 55 + (($visibleCount * 13) % 246);
        $sale = $visibleCount % 4 === 0 ? max(35, $regular - (10 + ($visibleCount % 35))) : null;
        $productColors = [
            $colors[$visibleCount % count($colors)],
            $colors[($visibleCount + 4) % count($colors)],
            $colors[($visibleCount + 8) % count($colors)],
        ];
        $productSizes = array_slice($sizes, $visibleCount % 4, 4);
        $rating = [3.0, 3.5, 4.0, 4.5, 5.0][$visibleCount % 5];
        $stock = $visibleCount % 13 === 0 ? 0 : 3 + (($visibleCount * 7) % 64);
        $backorders = $stock === 0 && $visibleCount % 2 === 0;
        $type = in_array($name, $variableProductNames, true) ? 'variable' : 'simple';
        $sku = 'demo-' . str_pad((string) $visibleCount, 3, '0', STR_PAD_LEFT) . '-' . slugify($name);

        $rows[] = productRow($type, $sku, $name, $category, $style, $audience, (float) $regular, $sale === null ? null : (float) $sale, $productColors, $productSizes, $rating, $stock, $visibleCount % 11 === 0, $backorders, $visibleCount % 10 === 0 ? 4 : ($visibleCount % 6 === 0 ? 3 : 1), $tagsByCategory[$category] ?? [], '', 'visible', $visibleCount);

        if ($type === 'variable') {
            foreach (array_slice($productColors, 0, 2) as $colorIndex => $color) {
                foreach (array_slice($productSizes, 0, 2) as $sizeIndex => $size) {
                    $rows[] = productRow('variation', $sku . '-var-' . slugify($color) . '-' . slugify($size), $name . ' - ' . $color . ' / ' . $size, $category, $style, $audience, (float) $regular, $sale === null ? null : (float) $sale, [$color], [$size], $rating, max(0, $stock - $colorIndex - $sizeIndex), false, false, 0, [], $sku, 'hidden', $sizeIndex + $colorIndex);
                }
            }
        }
    }
}

$suffixes = ['Core', 'Studio', 'Urban', 'Weekend', 'Premium', 'Heritage', 'Active', 'Resort', 'Daily', 'Limited'];
$fallbackCategories = array_keys($namesByCategory);

while ($visibleCount < 100) {
    $visibleCount++;
    $category = $fallbackCategories[$visibleCount % count($fallbackCategories)];
    $name = $suffixes[$visibleCount % count($suffixes)] . ' ' . $category . ' Item ' . $visibleCount;
    $style = $styles[$visibleCount % count($styles)];
    $audience = $categoryAudience[$visibleCount % count($categoryAudience)];
    $regular = 45 + (($visibleCount * 17) % 255);
    $sale = $visibleCount % 4 === 0 ? max(30, $regular - 20) : null;
    $productColors = [$colors[$visibleCount % count($colors)], $colors[($visibleCount + 3) % count($colors)]];
    $productSizes = array_slice($sizes, $visibleCount % 5, 4);
    $sku = 'demo-' . str_pad((string) $visibleCount, 3, '0', STR_PAD_LEFT) . '-' . slugify($name);

    $rows[] = productRow('simple', $sku, $name, $category, $style, $audience, (float) $regular, $sale === null ? null : (float) $sale, $productColors, $productSizes, [3.0, 3.5, 4.0, 4.5, 5.0][$visibleCount % 5], $visibleCount % 9 === 0 ? 0 : 10 + $visibleCount, $visibleCount % 12 === 0, $visibleCount % 18 === 0, $visibleCount % 8 === 0 ? 3 : 1, $tagsByCategory[$category] ?? [], '', 'visible', $visibleCount);
}

$handle = fopen($outputFile, 'wb');
if ($handle === false) {
    fwrite(STDERR, "Unable to open output file: {$outputFile}\n");
    exit(1);
}

fputcsv($handle, $headers);
foreach ($rows as $csvRow) {
    fputcsv($handle, $csvRow);
}

fclose($handle);

printf(
    "Generated %s with %d visible products and %d total CSV rows.\n",
    $outputFile,
    $visibleCount,
    count($rows)
);
