<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryDelete extends LearningRegistryDefault{
  
    protected $ids;
  
    function set_ids($ids){
      $this->ids = $ids;
    }
  
    function create_document(){
    
      $submission = new \StdClass;
      
      $submission->request_ids[] = $this->ids;
      
      $data_to_send = json_encode($submission);
      
      return $data_to_send;
    
    }
    
    function publishService(){
      $this->document = $this->create_document();
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