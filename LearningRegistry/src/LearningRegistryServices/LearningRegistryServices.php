<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryServices extends LearningRegistryDefault
{
  
    protected $services = array();
  
    public function listServices()
    {
    
        $responseBody = json_decode($this->data->response);
        foreach ($responseBody->services as $service) {
            if ($service->active == 1) {
                $this->services[] = $service->service_name;
            }
        }
    
    }
    
    public function servicesService()
    {
        $this->service($this->getNodeUrl(), "services", null, null, "GET");
    }
}
