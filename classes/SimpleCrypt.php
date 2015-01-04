<?php

/**
 * Simple encryption with key.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class SimpleCrypt
{

    /**
     * @param mixed  $value
     * @param string $key
     *
     * @return string
     */
    public function encrypt($value, $key)
    {
        $result = null;
        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            $char = substr($value, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    /**
     * @param string $value
     * @param string $key
     *
     * @return mixed
     */
    public function decrypt($value, $key)
    {
        $result = null;
        $value = base64_decode($value);
        $length = strlen($value);
        for ($i = 0; $i < $length; $i++) {
            $char = substr($value, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }
}
