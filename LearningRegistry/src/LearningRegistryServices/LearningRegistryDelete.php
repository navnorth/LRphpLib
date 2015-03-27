<?PHP

  namespace LearningRegistry\LearningRegistryServices;

class LearningRegistryDelete extends LearningRegistryDefault
{
  
    protected $ids;
  
    public function setIds($ids)
    {
        $this->ids = $ids;
    }
  
    public function createDocument()
    {
    
        $submission = new \StdClass;
      
        $submission->request_ids[] = $this->ids;
      
        $data_to_send = json_encode($submission);
      
        return $data_to_send;
    
    }
    
    public function publishService()
    {
        $this->document = $this->create_document();
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
