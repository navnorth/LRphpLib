<?PHP

  namespace LearningRegistry\LearningRegistryDocuments;

class LearningRegistryDCMetadata extends LearningRegistryDocument
{
    
    public function create()
    {
    
        $this->LearningRegistryService->setResFields(
            array(
            'resource_data_type' => 'metadata',
            'active' => true,
            'payload_schema' => array('DC 1.1'),
            'payload_placement' => 'inline',
            )
        );
      
        $this->LearningRegistryService->setTosFields(
            array(
            'submission_TOS' => "Standard",
            )
        );
    
    }
}
