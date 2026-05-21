<?php

require_once __DIR__ . '/class-icons.php';

class ShopCo_UI 
{
    public static function field( 
        string $icon,
        string $type = "text",
        string $placeholder = "", 
        string $label = "",
        string $mode = "",
    ) {
        $modes = array(
            "white",
        );

        $svgIcon = ShopCo_Icons::get_icon($icon);
        $mode = in_array( $mode, $modes, true ) ? $mode : "";
        $label = $label ?: $placeholder;
        
        $classes = "site-field" . ($mode ? " site-field--$mode" : "");

        return "<label class=\"$classes\">
                    <input type=\"$type\" class=\"site-field__input\" placeholder=\"$placeholder\">
                    <span class=\"site-field__icon opacity-40\">
                        $svgIcon
                    </span>
                    <span class=\"visually-hidden\">$label</span>
                </label>";
    }
}
