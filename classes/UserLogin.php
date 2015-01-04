<?php

/**
 * Handles user login.
 *
 * A session must be started in order to use this class.
 *
 * @author  Christian Blos <christian.blos@gmx.de>
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link    https://github.com/christianblos
 */
class UserLogin
{

    /**
     * @var string
     */
    protected $sessionName;

    /**
     * @var string
     */
    protected $cookieName;

    /**
     * @param string      $sessionName Name of session key.
     * @param string|null $cookieName  Name of cookie for permanent login or null to generate one.
     */
    public function __construct($sessionName, $cookieName = null)
    {
        $this->sessionName = $sessionName;
        $this->cookieName = $cookieName ?: sha1($sessionName);
    }

    /**
     * Login a user.
     *
     * The identifier parameter must be a value that identifies a user (e.g. userId).
     * It will be stored in the session as is. If you want to encrypt the value, you have
     * to do it yourself.
     * If a duration (in seconds) is given, a cookie will be set for permanent login.
     *
     * @param mixed $identifier
     * @param mixed $duration
     * @param bool  $regenerateSessionId
     *
     * @return void
     */
    public function login($identifier, $duration = 0, $regenerateSessionId = true)
    {
        if ($regenerateSessionId) {
            session_regenerate_id(true);
        }
        $_SESSION[$this->sessionName] = $identifier;

        if ($duration > 0) {
            $key = md5($this->sessionName);
            $value = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $identifier, MCRYPT_MODE_ECB);
            $value = base64_encode($value);
            setcookie($this->cookieName, $value, time() + $duration, '/');
        }
    }

    /**
     * @return void
     */
    public function logout()
    {
        unset($_SESSION[$this->sessionName]);
        setcookie($this->cookieName, '', 0, '/');
    }

    /**
     * Get user identifier for current logged in user.
     *
     * @return mixed|null
     */
    public function getIdentifier()
    {
        $identifier = null;
        if (isset($_SESSION[$this->sessionName])) {
            $identifier = $_SESSION[$this->sessionName];
        } elseif (isset($_COOKIE[$this->cookieName])) {
            $key = md5($this->sessionName);
            $value = base64_decode($_COOKIE[$this->cookieName]);
            $value = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $value, MCRYPT_MODE_ECB);
            $identifier = rtrim($value);
            $this->login($identifier);
        }
        return $identifier;
    }
}
