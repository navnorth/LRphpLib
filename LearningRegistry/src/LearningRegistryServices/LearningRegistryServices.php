<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryServices extends LearningRegistryDefault{
  
    protected $services = array();
  
    function list_services(){
    
      $responseBody = json_decode($this->data->getBody());
      foreach($responseBody->services as $service){
        if($service->active == 1){
          $this->services[] = $service->service_name;
        }
      }
      print_r($this->services);
    
    }
    
    function servicesService(){
      $this->service($this->getNodeUrl(), "status", null, null, "GET");
    }
    
  }