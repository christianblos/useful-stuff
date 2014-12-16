<?php

/**
 * Utilities for strings.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class StringUtils
{

    /**
     * Convert value to camel case string.
     *
     * @param string $value
     *
     * @return string
     */
    public function camelCase($value)
    {
        $value = str_replace(['_', '-'], ' ', $value);
        $value = preg_replace('/([a-z])([A-Z])/', '$1 $2', $value);
        $value = mb_convert_case($value, MB_CASE_TITLE);
        $value = preg_replace('/\s/', '', $value);
        return $value;
    }

    /**
     * Convert value to string with dashes as word separator.
     *
     * @param string $value
     *
     * @return string
     */
    public function dashed($value)
    {
        $value = preg_replace('/\s|_/', '-', $value);
        $value = preg_replace('/([a-z])([A-Z])/', '$1-$2', $value);
        $value = strtolower($value);
        return $value;
    }

    /**
     * Convert value to string with underscores as word separator.
     *
     * @param string $value
     *
     * @return string
     */
    public function snake($value)
    {
        $value = preg_replace('/\s|-/', '_', $value);
        $value = preg_replace('/([a-z])([A-Z])/', '$1_$2', $value);
        $value = strtolower($value);
        return $value;
    }

    /**
     * Convert value to url compatible string.
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public function slug($value, $delimiter = '-')
    {
        $value = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $value = preg_replace('/[^-\/+|\w ]/', '', $value);
        $value = preg_replace('/[\/_|+ -]+/', $delimiter, $value);
        $value = trim($value, $delimiter);
        return $value;
    }
}
