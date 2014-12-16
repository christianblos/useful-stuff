<?php

/**
 * Generator for passwords.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class PasswordGenerator
{

    /**
     * Generate a random password.
     *
     * @param int    $length
     * @param string $pool A string with available chars for the password.
     *
     * @return string
     */
    public function generate($length, $pool = null)
    {
        $password = '';

        if ($pool === null) {
            $pool = 'qwertzuiopasdfghjklcvbnmQWERTZUIOPASDFGHJKLCVBNM123456789+-_!$%&/()=?{[]}\@#*,.:;<>|~;';
        }

        for ($i = 0; $i < $length; $i++) {
            $pos = mt_rand(0, strlen($pool) - 1);
            $password .= substr($pool, $pos, 1);
        }

        return $password;
    }
}
