<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistrySlice extends LearningRegistryDefault
{
  
    public function showDocuments()
    {
        $data = json_decode($this->data->response);
        foreach ($data->documents as $document) {
            print_r($document);
        }
    }
  
    public function sliceService($parameters = null)
    {
      
        if (count($parameters)==0) {
            trigger_error("No Parameters set");
            return false;
        }
      
        $url = "?";
      
        if (isset($parameters['from'])) {
            $url .= "from=" . $parameters['from'];
        }
      
        if (isset($parameters['until'])) {
            $url .= "until=" . $parameters['until'];
        }
      
        if (isset($parameters['identity'])) {
            $url .= "identity=" . $parameters['identity'];
        }
      
        if (isset($parameters['any_tags'])) {
            $url .= "any_tags=" . $parameters['any_tags'];
        }
      
        if (isset($parameters['ids_only'])) {
            $url .= "ids_only=" . $parameters['ids_only'];
        }
      
        if (isset($parameters['resumption_token'])) {
            $url .= "resumption_token=" . $parameters['resumption_token'];
        }
      
        echo $this->getNodeUrl() . "obtain" . $url . "<br />";
    
        $this->service($this->getNodeUrl(), "slice" . $url, null, null, "GET");
      
    }
}
