<?php

/**
 * Helps to work with version numbers.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class VersionNumberUtils
{

    /**
     * Traverse through all numeric parts of a version number.
     *
     * The callback function will be called for any numeric value of
     * the version number, starting from left to right. The following
     * parameters will be given to that function:
     * 1. The position of the part (starting with 0)
     * 2. The value of the part
     *
     * If the callback function returs a numeric value, the version
     * part will be replaced by this value.
     *
     * @param string $version
     * @param mixed  $callback
     *
     * @return string
     */
    public function traverse($version, $callback)
    {
        $split = preg_split('/([^0-9]+)/', $version, 0, PREG_SPLIT_DELIM_CAPTURE);
        $i = 0;
        foreach ($split as $key => $part) {
            if (is_numeric($part)) {
                $val = call_user_func($callback, $i, $split[$key]);
                if (is_numeric($val)) {
                    $split[$key] = $val;
                }
                $i++;
            }
        }
        return implode('', $split);
    }

    /**
     * Increment the version number.
     *
     * The number at the given position will be incremented by 1 and all
     * further numbers at the right positions will be set to 0.
     * The position starts with 0 from left to right.
     *
     * @param string $version
     * @param int    $position
     *
     * @return string
     */
    public function increment($version, $position = 0)
    {
        $callback = function ($pos, $value) use ($position) {
            if ($pos == $position) {
                return $value + 1;
            } elseif ($pos > $position) {
                return 0;
            } else {
                return $value;
            }
        };
        return $this->traverse($version, $callback);
    }

    /**
     * Set version parts to 0 starting by the given position.
     * The position starts with 0 from left to right.
     *
     * @param string $version
     * @param int    $position
     *
     * @return string
     */
    public function floor($version, $position = 0)
    {
        $callback = function ($pos, $value) use ($position) {
            if ($pos >= $position) {
                return 0;
            } else {
                return $value;
            }
        };
        return $this->traverse($version, $callback);
    }
}
