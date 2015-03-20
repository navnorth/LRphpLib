<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryStatus extends LearningRegistryDefault{
  
    function data(){
      $responseBody = json_decode($this->data->getBody());
      print_r($responseBody);  
    }
  
    function statusService(){
      $this->service($this->getNodeUrl(), "status", null, null, "GET");
    }
    
  }