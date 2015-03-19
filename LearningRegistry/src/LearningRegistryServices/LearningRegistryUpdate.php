<?PHP

	namespace LearningRegistry\LearningRegistryServices;

	class LearningRegistryUpdate extends LearningRegistryPublish{
	
		function updateService(){
			if($this->document != false){
				if($this->getAuthorization() == "basic"){
					if($this->getPassword() == false || $this->getUsername() == false){
						trigger_error("Username and Password not set");
					}
				} else if($this->getAuthorization() == "oauth"){
					if($this->getUsername() == false || $this->getOAuthSignature() == false){
						trigger_error("Username and OAuth not set");
					}
				}
				$this->service($this->getNodeUrl(), "publish", $this->getAuthorization(), $this->document, "POST");
			}
		}
		
	}