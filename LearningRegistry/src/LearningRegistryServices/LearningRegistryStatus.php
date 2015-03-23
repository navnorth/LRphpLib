<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryStatus extends LearningRegistryDefault{
  
    function showStatus(){
      $responseBody = json_decode($this->data->response);
      print_r($responseBody);  
    }
  
    function statusService(){
      $this->service($this->getNodeUrl(), "status", null, null, "GET");
    }
    
  }