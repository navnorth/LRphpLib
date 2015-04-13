<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryObtain extends LearningRegistryDefault
{
  
    public function showDocuments()
    {
        $data = json_decode($this->data->response);
        foreach ($data->documents as $document) {
            print_r($document);
        }
    }
    
    public function getDocuments()
    {
        $data = json_decode($this->data->response);
        return $data->documents;
    }
  
    public function obtainService($parameters = null)
    {
      
        if (count($parameters)==0) {
            trigger_error("No Parameters set");
            return false;
        }
      
        if (isset($parameters['by_doc_ID']) && isset($parameters['by_resource_ID'])) {
            if ($parameters['by_doc_ID'] && $parameters['by_resource_ID']) {
                trigger_error("doc ID and resource ID can't both be true");
                return false;
            }
        }
      
        $url = "?";
      
        if (isset($parameters['request_id'])) {
            $url .= "request_id=" . $parameters['request_id'];
        }
      
        if (isset($parameters['by_doc_ID'])) {
            if ($parameters['by_doc_ID']) {
                $url .= "&by_doc_ID=" . $parameters['by_doc_ID'];
            }
        }
      
        if (isset($parameters['by_resource_ID'])) {
            if ($parameters['by_resource_ID']) {
                $url .= "&by_resource_ID=" . $parameters['by_resource_ID'];
            }
        }
      
        if (isset($parameters['ids_only'])) {
            if ($parameters['ids_only']) {
                $url .= "&ids_only=" . $parameters['ids_only'];
            }
        }
      
        if (isset($parameters['resumption_token'])) {
            $url .= "&resumption_token=" . $parameters['resumption_token'];
        }
    
        $this->service($this->getNodeUrl(), "obtain" . $url, null, null, "GET");
      
    }
}
