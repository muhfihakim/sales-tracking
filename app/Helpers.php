<?php

if (!function_exists('excerpt')) {
    function excerpt($text, $maxLength = 20)
    {
        if (strlen($text) > $maxLength) {
            return substr($text, 0, $maxLength) . '...';
        }
        return $text;
    }
}
