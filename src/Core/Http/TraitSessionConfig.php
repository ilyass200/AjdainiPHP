<?php

/*
 * This file is part of the AjdainiPHP Framework.
 *
 * (c) Ajdaini Ilyass <ajdainibac@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace AjdainiPHP\Core\Http;

trait TraitSessionConfig
{
    private $session_name = NULL;
    private $logout_method = NULL;
    private $session_path = false;
    private $secure_session  = false;
    private $security_cookie_name = NULL;
    private $security_cookie_lifetime = NULL;
    
    private function setSessionName(string $value)
    {
        (strlen($value) > 0 ? $this->session_name = $value : '');
    }

    private function setLogoutFile(string $method)
    {
        (strlen($method) > 0 ? $this->logout_method = $method : '');
    }

    private function setSessionPath(string $dir)
    {
        $dir = ROOT.'/'.$dir;

        if(is_dir($dir))
        {
            $this->session_path = $dir;
        }
        else
        {
            throw new \Exception("The folder '$dir' does not exist !");
        }
    }
    
    private function setSecureSession(bool $value)
    {
        $this->secure_session = $value;
    }

    private function setSecurityCookieName(string $value)
    {
        $this->security_cookie_name = $value;
    }

    private function setSecurityCookieLifetime(int $seconds)
    {
       $this->security_cookie_lifetime = $seconds;
    }

    public function getSessionName()
    {
        return ($this->session_name !== NULL ? $this->session_name : 'PHPSESSID');
    }  

    public function getLogoutFile()
    {
        return $this->logout_method;
    }

    public function getSessionPath()
    {
        return $this->session_path;
    }

    public function getSecureSession()
    {
        return $this->secure_session;
    }

    public function getSecurityCookieName()
    {
        return ($this->security_cookie_name !== NULL ? $this->security_cookie_name: $this->generateKey(10));
    }

    public function getSecurityCookieLifetime()
    {
        return ($this->security_cookie_lifetime !== NULL ? $this->security_cookie_lifetime : 3600);
    }

    private function initConfig()
    {
        $this->setSessionName($this->config['session_name']);
        $this->setLogoutFile($this->config['logout_method']);
        $this->setSessionPath($this->config['session_path']);
        $this->setSecureSession($this->config['secure_session']);   
        $this->setSecurityCookieName($this->config['security_cookie_name']);
        $this->setSecurityCookieLifetime($this->config['security_cookie_lifetime']);
    }
}

?>