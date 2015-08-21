<?PHP

  namespace LearningRegistry\LearningRegistryDocuments;

class LearningRegistryReplaceDocument extends LearningRegistryDocument
{
  
    protected $LearningRegistryConfig;
    protected $document;
    protected $id;
    
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
                default:    if (is_object($this->document->{$field})) {
                                unset($this->document->{$field});
                } else {
                    unset($this->document->{$field});
                }
                    break;
            }
        }
        $LR->setResFields(array("replaces" => array($this->id)));
    }
    
    public function newResourceData($LR, $resourceData)
    {
        $LR->setResFields(array("resource_data" => $resourceData));
    }
}
