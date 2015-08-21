<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryUpdate extends LearningRegistryPublish
{
  
    public function getNewID()
    {
        $data = json_decode($this->data->response);
        return $data->document_results[0]->doc_ID;
    }
  
    public function verifyUpdatedDocument($tos = false)
    {
      
        if ($this->verifyDocument()) {
            if (isset($this->resourceData->payload_locator)) {
                unset($this->resourceData->payload_locator);
            }

            if (!isset($this->resourceData->payload_placement)) {
                trigger_error("payload placement not set");
                return false;
            }
            
            if (!isset($this->resourceData->replaces)) {
                trigger_error("replaces not set");
                return false;
            }
      
            if (!isset($this->resourceData->resource_data)) {
                trigger_error("resource_data not set");
                return false;
            }

            return true;

        }
    
    }
  
    public function updateService()
    {
        if ($this->document != false) {
            if ($this->getAuthorization() == "basic") {
                if ($this->getPassword() == false || $this->getUsername() == false) {
                    trigger_error("Username and Password not set");
                }
            } elseif ($this->getAuthorization() == "oauth") {
                if ($this->getUsername() == false || $this->getOAuthSignature() == false) {
                    trigger_error("Username and OAuth not set");
                }
            }
            $this->service($this->getNodeUrl(), "publish", $this->getAuthorization(), $this->document, "POST");
        }
    }
}
