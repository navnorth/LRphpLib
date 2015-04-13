<?PHP

  namespace LearningRegistry\LearningRegistryDocuments;

class LearningRegistryParadata extends LearningRegistryDocument
{
    
    public function create()
    {
    
        $this->LearningRegistryService->setResFields(
            array(
            'resource_data_type' => 'paradata',
            'active' => true,
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
