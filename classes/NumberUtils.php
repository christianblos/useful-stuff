<?php

/**
 * Utilities for numbers.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class NumberUtils
{
    /**
     * Create a random number with precision.
     *
     * @param float $min
     * @param float $max
     * @param int   $precision
     *
     * @return int|float
     */
    public function random($min, $max, $precision = 0)
    {
        $exp = pow(10, $precision);
        $min = (int)($min * $exp);
        $max = (int)($max * $exp);
        return mt_rand($min, $max) / $exp;
    }

    /**
     * Get number from string.
     *
     * It cuts all non numeric strings except of the decimal separator.
     *
     * @param string $numberString
     * @param string $decimalSeparator .
     *
     * @return float
     */
    public function fromString($numberString, $decimalSeparator = '.')
    {
        $numberString = preg_replace('/[^0-9' . preg_quote($decimalSeparator, '/') . ']/', '', $numberString);
        $numberString = str_replace($decimalSeparator, '.', $numberString);
        return (float)$numberString;
    }

    /**
     * Round a number to a specific distance.
     *
     * Examples:
     * distance: 10   => 0, 10, 20, 30, ...
     * distance: 0.5  => 0, 0.5, 1, 1.5, ...
     * distance: 0.25 => 0, 0.25, 0.5, 0.75, 1, ...
     * distance: 1/7  => 0, 1/7, 2/7, 3/7, ...
     *
     * If you have a distance of "0.25" for example, the
     * value "3.815" will be rounded to "3.75".
     *
     * The mode can be one of:
     *  - PHP_ROUND_HALF_UP
     *  - PHP_ROUND_HALF_DOWN
     *
     * @param float $number
     * @param float $distance
     * @param int   $mode
     *
     * @return float
     */
    public function roundToDistance($number, $distance, $mode = PHP_ROUND_HALF_UP)
    {
        $multiplier = floor($number / $distance);
        $floor = $distance * $multiplier;
        $percent = ($number - $floor) / $distance;

        if ($percent < 0.5) {
            $value = $floor;
        } elseif ($percent > 0.5) {
            $value = $floor + $distance;
        } elseif ($mode == PHP_ROUND_HALF_DOWN) {
            $value = $floor;
        } else {
            $value = $floor + $distance;
        }

        return $value;
    }

    /**
     * Format a number.
     *
     * @param float  $number
     * @param int    $decimals
     * @param string $decimalPoint
     * @param string $thousandsSeparator
     * @param bool   $addSign
     *
     * @return string
     */
    public function format($number, $decimals = 0, $decimalPoint = '.', $thousandsSeparator = ',', $addSign = false)
    {
        $format = number_format($number, $decimals, $decimalPoint, $thousandsSeparator);
        if ($addSign) {
            $format = ($number >= 0 ? '+' : '') . $format;
        }
        return $format;
    }
}
