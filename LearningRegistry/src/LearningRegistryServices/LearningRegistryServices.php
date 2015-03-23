<?PHP

  namespace LearningRegistry\LearningRegistryServices;

  class LearningRegistryServices extends LearningRegistryDefault{
  
    protected $services = array();
  
    function listServices(){
	
      $responseBody = json_decode($this->data->response);
      foreach($responseBody->services as $service){
        if($service->active == 1){
          $this->services[] = $service->service_name;
        }
      }
      print_r($this->services);
    
    }
    
    function servicesService(){
      $this->service($this->getNodeUrl(), "services", null, null, "GET");
    }
    
  }