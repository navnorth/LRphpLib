<?PHP

	namespace LearningRegistry;

	class LearningRegistryConfig{
	
		protected $username;
		protected $password;
		protected $url;
		protected $https;
		protected $signing;
		protected $auth;
		protected $oauthSignature;
		
		function getSigning(){
			if(isset($this->signing)){
				return $this->signing;
			}
			return false;
		}
		
		function getOAuthSignature(){
			if(isset($this->oauthSignature)){
				return $this->oauthSignature;
			}
			return false;
		}
		
		function getAuthorization(){
			if(isset($this->auth)){
				return $this->auth;
			}
			return "basic";
		}
		
		function getPassword(){
			if(isset($this->password)){
				return $this->password;
			}
			return false;
		}
		
		function getUsername(){
			if(isset($this->username)){
				return $this->username;
			}
			return false;
		}
		
		function getProtocol(){
			if(isset($this->https)){
				if($this->https == 1){
					return "https";
				}
			}
			return "http";
		}
		
		function getUrl(){
			if(isset($this->url)){
				return $this->url;
			}
			trigger_error("URL not set");
			return false;
		}
		
		function __construct($config){
		
			if(is_array($config)){
				return $this->process_array($config);
			}else if(file_exists($config)){
				if(is_object(json_decode(file_get_contents($config))) || is_array(json_decode(file_get_contents($config)))){
					return $this->process_json(json_decode(file_get_contents($config)));
				}else{
					return $this->process_file(file_get_contents($config));
				}
			}else if(is_object(json_decode($config)) || is_array(json_decode($config))){
				return $this->process_json(json_decode($config));
			}else{
				trigger_error("No Configuration Setup found");
				return false;
			}
		
		}
		
		function process_file($config){
		
			$parameters = explode("\n", $config);
			if(count($parameters)==1){
				$parameters = explode("\r", $config);
			}
		
			foreach($parameters as $parameter){
				$variables = explode(":", $parameter);
				$this->{trim($variables[0])} = trim($variables[1]);	
			}
			
			if(isset($this->url)){
				if(filter_var("http://" . $this->url, FILTER_VALIDATE_URL) === false) {
					trigger_error($this->url . " is not a valid URL");
					return false;
				}
				if(substr($this->url,strlen($this->url)-1,1)!=="/"){
					$this->url .= "/";
				}
			}
			
			return true;

		}
		
		function process_json($config){
		
			if(isset($config->username)){
				$this->username = $config->username;
			}
			
			if(isset($config->password)){
				$this->password = $config->password;
			}
			
			if(isset($config->auth)){
				$this->auth = $config->auth;
			}
			
			if(isset($config->oauthSignature)){
				$this->oauthSignature = $config->oauthSignature;
			}
			
			if(isset($config->url)){
				if(filter_var("http://" . $config->url, FILTER_VALIDATE_URL) === false) {
					trigger_error($config->url . " is not a valid URL");
					return false;
				}
				if(substr($config->url,strlen($config->url)-1,1)!=="/"){
					$config->url .= "/";
				}
				$this->url = $config->url;
			}
			
			if(isset($config->https)){
				$this->https = (integer) $config->https;
			}
			
			if(isset($config->signing)){
				$this->signing = (integer) $config->signing;
			}
			
			return true;

		}
		
		function process_array($config){
		
			if(isset($config['username'])){
				$this->username = $config['username'];
			}
			
			if(isset($config['password'])){
				$this->password = $config['password'];
			}
			
			if(isset($config['auth'])){
				$this->auth = $config['auth'];
			}
			
			if(isset($config['oauthSignature'])){
				$this->oauthSignature = $config['oauthSignature'];
			}
			
			if(isset($config['url'])){
				if(filter_var("http://" . $config['url'], FILTER_VALIDATE_URL) === false) {
					trigger_error($config['url'] . " is not a valid URL");
					return false;
				}
				if(substr($config['url'],strlen($config['url'])-1,1)!=="/"){
					$config['url'] .= "/";
				}
				$this->url = $config['url'];
			}
			
			if(isset($config['https'])){
				$this->https = (integer) $config['https'];
			}
			
			if(isset($config['signing'])){
				$this->signing = (integer) $config['signing'];
			}
			
			return true;

		}
		
	}