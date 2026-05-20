<?php

require_once __DIR__ . '/class-icons.php';

class ShopCo_Assets
{
    public static function asset( 
        string $path,
    ) {
        $path = trim($path, '/');

        return get_template_directory_uri() . '/resources/' . $path;
    }

    public static function img( 
        string $path,
        string $alt = '',
        string $class = '',
        array $sizes = array(),
    ) {
        $path = trim($path, '/');
        $source = get_template_directory_uri() . '/resources/' . $path;
        $width = $sises[0] ?? '';
        $height = $sizes[1] ?? $sizes[0] ?? '';

        return "<img src=\"$source\" class=\"$class\" alt=\"$alt\" width=\"$width\" height=\"$height\">";
    }
}
