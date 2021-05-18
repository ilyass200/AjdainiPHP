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

class Cookie
{
    private $name;
    private $value;
    private $lifetime;
    private $path = NULL;
    private $domain = NULL;
    private $secure;
    private $httpOnly = true;

    function __construct(string $name,string $value,int $lifetime,$options = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->lifetime = $lifetime;
        (isset($options['path']) ? $this->lifetime = $options['path'] : '');
        (isset($options['secure']) ? $this->secure = $options['secure'] : '');
        (isset($options['httpOnly']) ? $this->lifetime = $options['httpOnly'] : '');
        (isset($options['domain']) ? $this->domain = $options['domain'] : '');
        $this->init();
    }

    public function isHttps()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER('HTTPS') === 'on');
    }

    public function isSecure()
    {
        return ($this->secure == 1);
    }

    public function isHttpsOnly()
    {
        return ($this->httpOnly == 1);
    }
    
    public function isPath()
    {
        return (!empty($this->path));
    }

    public function isDomain()
    {
        return (!empty($this->domain));
    }

    public function init()
    {
        $path = ($this->isPath() ? $this->path : null);
        $domain = ($this->isDomain() ? $this->domain : null);
        $secure = (empty($this->secure) ? $this->isHttps() : $this->secure);
        $httpOnly = $this->isHttpsOnly();

        setcookie($this->name,$this->value,
            time() + $this->lifetime,
            $path,
            $domain,
            $secure,
            $httpOnly,
         );
    }
    
}

?>
