<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AjdainiPHP\Core\Http;

use AjdainiPHP\App\App;
use AjdainiPHP\Core\Http\TraitSessionConfig;

class Session 
{
    use TraitSessionConfig;
    private $config = [];
    
    function __construct(Array $config)
    {
        $this->config = $config; 
        $this->initConfig();    
        $this->start();
    }

    private function start()
    {
            if($this->secure_session)
            {
                $this->secureSession($this->getSecurityCookieLifetime(),$this->logout_method);
            }
            else
            {
                $this->init();
                session_start();
            }
    }

    public function set(string $name,string $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get(string $name, string $default = '')
    {
       (strlen($default) > 0 ?  $this->set($name,$default) > 0 : '');
       return (!isset($_SESSION[$name]) && strlen($default) < 1 ? false : $_SESSION[$name]);  

    }

    private function init()
    {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? ini_set('session.cookie_secure', 1) : '');
        ini_set('session.sid_bits_per_character', 6);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.name',$this->getSessionName());
        ($this->session_path ? ini_set('session.save_path',$this->getSessionPath()) : '');
    }

    private function secureSession(int $lifetime,string $logout_method = '')
    {
        $this->init();                                                         
        session_start();
        
        $this->secure_session = true;
        $session = $this->getSessionName();
        $cookie_name = $this->getSecurityCookieName();
        $session_name = $this->getSessionName();

        if(!isset($_COOKIE[$cookie_name]) or !isset($_SESSION[$cookie_name]))
        {
           $key = $this->generateKey();
           setcookie($cookie_name,$key,time() + $lifetime,null,null,false,true);
           $this->set($cookie_name,$key); 
        }
        else
        {
            if($_SESSION[$cookie_name] !== $_COOKIE[$cookie_name])
            {                   
                session_destroy();
                session_start();
                unset($_COOKIE[$cookie_name]);
                header("location: index.php?t=".$this->getLogoutFile());
            }
            else
            { 
                $key = $this->generateKey();
                setcookie($cookie_name,$key,time() + $lifetime,null,null,false,true);
                $this->set($cookie_name,$key);  
            }
        }
    } 

    private function generateKey($length = 32)
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 5)), 0, $length);
    } 
}

?>