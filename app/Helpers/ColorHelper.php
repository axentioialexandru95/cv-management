<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Darken a hex color by a percentage
     */
    public static function darken(string $hex, int $percent): string
    {
        $rgb = self::hexToRgb($hex);

        $rgb['r'] = (int) max(0, min(255, $rgb['r'] - ($rgb['r'] * $percent / 100)));
        $rgb['g'] = (int) max(0, min(255, $rgb['g'] - ($rgb['g'] * $percent / 100)));
        $rgb['b'] = (int) max(0, min(255, $rgb['b'] - ($rgb['b'] * $percent / 100)));

        return self::rgbToHex($rgb['r'], $rgb['g'], $rgb['b']);
    }

    /**
     * Lighten a hex color by a percentage
     */
    public static function lighten(string $hex, int $percent): string
    {
        $rgb = self::hexToRgb($hex);

        $rgb['r'] = (int) max(0, min(255, $rgb['r'] + ((255 - $rgb['r']) * $percent / 100)));
        $rgb['g'] = (int) max(0, min(255, $rgb['g'] + ((255 - $rgb['g']) * $percent / 100)));
        $rgb['b'] = (int) max(0, min(255, $rgb['b'] + ((255 - $rgb['b']) * $percent / 100)));

        return self::rgbToHex($rgb['r'], $rgb['g'], $rgb['b']);
    }

    /**
     * Convert hex color to RGB array
     */
    public static function hexToRgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Convert RGB to hex color
     */
    public static function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    /**
     * Get RGB CSS value from hex
     */
    public static function toRgbCss(string $hex): string
    {
        $rgb = self::hexToRgb($hex);

        return "{$rgb['r']}, {$rgb['g']}, {$rgb['b']}";
    }
}
