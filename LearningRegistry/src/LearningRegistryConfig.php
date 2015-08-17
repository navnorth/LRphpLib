<?PHP

  namespace LearningRegistry;

class LearningRegistryConfig
{

    protected $username;
    protected $password;
    protected $url;
    protected $https;
    protected $signing;
    protected $auth;
    protected $oauthSignature;
    protected $keyPath;
    protected $keyOwner;
    protected $publicKeyPath;
    protected $loader;
    protected $keyContents;

    public function setLoader($loader)
    {
        $this->loader = $loader;
    }

    public function setKeyPath($keyPath)
    {
        $this->keyPath = $keyPath;
    }
    
    public function setKeyContents($keyContents)
    {
        $this->keyContents = $keyContents;
    }
    
    public function setKeyOwner($keyOwner)
    {
        $this->keyOwner = $keyOwner;
    }
    
    public function setPublicKeyPath($publicKey)
    {
        $this->publicKeyPath = $publicKey;
    }

    public function setSigning($signing)
    {
        $this->signing = $signing;
    }

    public function setOAuthSignature($oauthSignature)
    {
        $this->oauthSignature = $oauthSignature;
    }

    public function setAuthorization($auth)
    {
        $this->auth = $auth;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setPassPhrase($passphrase)
    {
        $this->passphrase = $passphrase;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setProtocol($https)
    {
        $this->https = $https;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setFingerprint($fingerprint)
    {
        $this->fingerprint = $fingerprint;
    }

    public function getPublicKeyPath()
    {
        if (isset($this->publicKeyPath)) {
            return $this->publicKeyPath;
        }
        return false;
    }
    
    public function getKey()
    {
    
        if (isset($this->keyContents)) {
            return $this->keyContents;
        }
        
        if (isset($this->keyPath)) {
            return file_get_contents($this->keyPath);
        }
        
        return false;
    
    }
    
    public function getKeyContents()
    {
        if (isset($this->keyContents)) {
            return $this->getKeyContents;
        }
        
        return false;
    }

    public function getKeyPath()
    {
        if (isset($this->keyPath)) {
            return $this->keyPath;
        }
        return false;
    }

    public function getKeyOwner()
    {
        if (isset($this->keyOwner)) {
            return $this->keyOwner;
        }
        return false;
    }

    public function getSigning()
    {
        if (isset($this->signing)) {
            return $this->signing;
        }
        return false;
    }

    public function getOAuthSignature()
    {
        if (isset($this->oauthSignature)) {
            return $this->oauthSignature;
        }
        return false;
    }

    public function getAuthorization()
    {
        if (isset($this->auth)) {
            return $this->auth;
        }
        return "basic";
    }

    public function getPassword()
    {
        if (isset($this->password)) {
            return $this->password;
        }
        return false;
    }

    public function getPassPhrase()
    {
        if (isset($this->passphrase)) {
            return $this->passphrase;
        }
        return false;
    }

    public function getUsername()
    {
        if (isset($this->username)) {
            return $this->username;
        }
        return false;
    }
    
    public function getLoader()
    {
        if (isset($this->loader)) {
            return $this->loader;
        }
        return false;
    }

    public function getProtocol()
    {
        if (isset($this->https)) {
            if ($this->https == 1) {
                return "https";
            }
        }
        return "http";
    }

    public function getUrl()
    {
        if (isset($this->url)) {
            return $this->url;
        }
        trigger_error("URL not set");
        return false;
    }

    public function getFingerprint()
    {
        if (isset($this->fingerprint)) {
            return $this->url;
        }
        return false;
    }

    public function __construct($config)
    {

        if (is_array($config)) {
            return $this->processArray($config);
        } elseif (file_exists($config)) {
            if (is_object(json_decode(file_get_contents($config)))
                || is_array(json_decode(file_get_contents($config)))
            ) {
                return $this->processJson(json_decode(file_get_contents($config)));
            } else {
                return $this->processFile(file_get_contents($config));
            }
        } elseif (is_object(json_decode($config)) || is_array(json_decode($config))) {
            return $this->processJson(json_decode($config));
        } else {
            trigger_error("No Configuration Setup found");
            return false;
        }

    }

    public function processFile($config)
    {

        $parameters = explode("\n", $config);
        if (count($parameters)==1) {
            $parameters = explode("\r", $config);
        }

        foreach ($parameters as $parameter) {
            $variables = explode("::", $parameter);
            $this->{trim($variables[0])} = trim($variables[1]);
        }

        if (isset($this->url)) {
            if (filter_var("http://" . $this->url, FILTER_VALIDATE_URL) === false) {
                trigger_error($this->url . " is not a valid URL");
                return false;
            }
            if (substr($this->url, strlen($this->url)-1, 1)!=="/") {
                $this->url .= "/";
            }
        }

        return true;

    }

    public function processJson($config)
    {

        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }

        if (isset($config->url)) {
            if (filter_var("http://" . $config->url, FILTER_VALIDATE_URL) === false) {
                trigger_error($config->url . " is not a valid URL");
                return false;
            }
            if (substr($config->url, strlen($config->url)-1, 1)!=="/") {
                $config->url .= "/";
            }
            $this->url = $config->url;
        }

        return true;

    }

    public function processArray($config)
    {

        foreach ($config as $key => $value) {
            $this->{$key} = $value;
        }

        if (isset($config['url'])) {
            if (filter_var("http://" . $config['url'], FILTER_VALIDATE_URL) === false) {
                trigger_error($config['url'] . " is not a valid URL");
                return false;
            }
            if (substr($config['url'], strlen($config['url'])-1, 1)!=="/") {
                $config['url'] .= "/";
            }
            $this->url = $config['url'];
        }

        return true;

    }
}
