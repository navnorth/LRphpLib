<?PHP

  namespace LearningRegistry\LearningRegistryDocuments;

class LearningRegistryReplaceDocument extends LearningRegistryDocument
{
  
    protected $LearningRegistryConfig;
    protected $document;
    protected $id;
      
    public function __construct($data)
    {
       
        if (is_array($data)) {
            $LRConfig = new \LearningRegistry\LearningRegistryConfig(
                array( "url" => $data[0])
            );
                                                         
            $LRObtain = new \LearningRegistry\LearningRegistryServices\LearningRegistryObtain($LRConfig);
                                                             
            $LRObtain->ObtainService(
                array(
                          "request_id" => $data[1],
                          "by_doc_ID" => "true",
                        )
            );
            $data = $LRObtain->getDocuments();
            $this->document = $data[0]->document[0];
            $this->id = $data[1];
          
        }
        
    }
    
    public function emptyDocument($LR)
    {
        foreach ($this->document as $field => $fieldValue) {
            switch($field){
                case "doc_type": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "active": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "resource_locator": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "keys": $LR->setResFields(array("keys" => ""));
                    break;
                case "TOS": $LR->setTosFields($fieldValue);
                    break;
                case "digital_signature": $LR->setSigFields($fieldValue);
                    break;
                case "resource_data_type": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "payload_locator": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "payload_placement": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "payload_schema": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "doc_version": $LR->setResFields(array($field => $fieldValue));
                    break;
                case "identity": $LR->setIdFields($fieldValue);
                    break;
                break;
            }
        }
    }
    
    public function setIdFields($fieldsArray)
    {
    
        $this->LearningRegistryService->setIdFields($fieldsArray);
    
    }
    
    public function setResFields($fieldsArray)
    {
    
        $this->LearningRegistryService->setResFields($fieldsArray);
    
    }
    
    public function setSigFields($fieldsArray)
    {
    
        $this->LearningRegistryService->setSigFields($fieldsArray);
    
    }
    
    public function setTosFields($fieldsArray)
    {
    
        $this->LearningRegistryService->setTosFields($fieldsArray);
    
    }
}
