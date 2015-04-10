<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryDefault
{
  
    protected $LearningRegistryConfig;
      
    public function __construct($config)
    {
        $this->LearningRegistryConfig = $config;
    }
    
	public function getMessage()
    {
        if (is_object(json_decode($this->data->response))) {
			$data = json_decode($this->data->response);
            return $data->message;
        }
    }
	
    public function getStatusCode()
    {
        if (is_object(json_decode($this->data->response))) {
            $data = $this->data->statusCode;
            return $data;
        }
    }
    
    public function getResponse()
    {
        if (is_object(json_decode($this->data->response))) {
            return json_decode($this->data->response);
        } else {
            return json_encode(array("response" => $this->data->response));
        }
    }
    
    public function checkNode()
    {
        $LR = new LearningRegistryStatus($this->LearningRegistryConfig);
        $LR->statusService();
        if ($LR->data->statusCode==200) {
            return true;
        }
        $this->data = $LR->data;
        return $LR->data->statusCode;
    }
    
    public function checkNodeActive()
    {
        $LR = new LearningRegistryStatus($this->LearningRegistryConfig);
        $LR->statusService();
        $response = json_decode($LR->data->response);
        if ($response->active == 1) {
            return true;
        }
        $this->data = $LR->data;
        return false;
    }
    
    public function getpublicKeyPath()
    {
        return $this->LearningRegistryConfig->getpublicKeyPath();
    }
    
    public function getKeyPath()
    {
        return $this->LearningRegistryConfig->getKeyPath();
    }
    
    public function getSigning()
    {
        return $this->LearningRegistryConfig->getSigning();
    }
    
    public function getOAuthSignature()
    {
        return $this->LearningRegistryConfig->getOAuthSignature();
    }
    
    public function getAuthorization()
    {
        return $this->LearningRegistryConfig->getAuthorization();
    }
    
    public function getNodeUrl()
    {
        return $this->LearningRegistryConfig->getProtocol() . "://" . $this->LearningRegistryConfig->getUrl();
    }
    
    public function getPassword()
    {
        return $this->LearningRegistryConfig->getPassword();
    }
    
    public function getUsername()
    {
        return $this->LearningRegistryConfig->getUsername();
    }
        
    public function oauthRequest($method)
    {
        return $this->LROAuth->request(
            $this->interface,
            $method,
            $this->document,
            $this->extraHeaders
        );
    }
    
    public function getUrl($method)
    {
    
        $client = new \GuzzleHttp\Client();
        if ($method == "POST") {
            try {
                $res = $client->post(
                    $this->interface,
                    [
                    'config' => [
                    'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    ]
                    ],
                    'headers' => $this->extraHeaders,
                    'body' => $this->document,
                    'exceptions' => true,
                    ]
                );
                return (object) array(
                "statusCode" => $res->getStatusCode(),
                "response" => $res->getBody()
                );
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->hasResponse()) {
                    return (object) array(
                    "statusCode" => $res->getStatusCode(),
                    "response" => $res->getBody()
                    );
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return (object) array(
                "statusCode" => "",
                "response" => "Invalid URL",
                );
            }
        } else {
            try {
                $res = $client->get(
                    $this->interface,
                    [
                    'config' => [
                    'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    ]
                    ],
                    'exceptions' => true,
                    ]
                );
                return (object) array(
                "statusCode" => $res->getStatusCode(),
                "response" => $res->getBody()
                );
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->hasResponse()) {
                    return (object) array(
                    "statusCode" => $res->getStatusCode(),
                    "response" => $res->getBody()
                    );
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return (object) array(
                "statusCode" => "",
                "response" => "Invalid URL"
                );
            }
        }
    }
    
    public function basicRequest($method)
    {
        return $this->getUrl($method);
    }
    
    public function noAuthRequest($method)
    {
        return $this->getUrl($method);
    }
    
    public function service($url, $service, $auth = null, $document = null, $method = "GET")
    {
      
        $this->interface = new \LearningRegistry\Http\LearningRegistryUri();
        $this->interface->setHost($url);
        $this->interface->setPath($service);
        $this->document = $document;
      
        if ($auth == "basic") {
            $this->extraHeaders = array(
                'Content-type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getUsername() . ':' . $this->getPassword())
              );
              
            $this->data = $this->basicRequest($method);
      
        } elseif ($auth == "oauth") {
            $storage = new \OAuth\Common\Storage\Session();
            $credentials = new \OAuth\Common\Consumer\Credentials(null, null, null);
            $httpClient = new \LearningRegistry\Http\LearningRegistryHTTPClient();
            $this->LROAuth = new \LearningRegistry\OAuth\LearningRegistryOAuth(
                $credentials,
                $httpClient,
                $storage
            );
        
            $this->extraHeaders = array(
                'Content-type' => 'application/json',
                'Authorization' => 'OAuth ' . base64_encode('oauth_consumer_key=' . $this->getUsername()
                                      . '&oauth_signature=' . $this->getOAuthSignature())
              );
              
            $this->data = $this->oauthRequest($method);
        
        } else {
            $this->data = $this->noAuthRequest($method);
      
        }
      
    }
}
