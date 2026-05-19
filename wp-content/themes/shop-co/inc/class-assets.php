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
}
