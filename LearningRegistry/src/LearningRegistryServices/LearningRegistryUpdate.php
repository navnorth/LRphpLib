<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryUpdate extends LearningRegistryPublish{
  
    function verifyUpdatedDocument($tos = FALSE){
      
      if($this->verifyDocument()){
    
        if(!isset($this->resourceData->replaces)){
          trigger_error("replaces not set");
          return false;
        }
      
        if(!isset($this->resourceData->resource_data)){
          trigger_error("resource_data not set");
          return false;
        }

        return true;  

      }
    
    }
  
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