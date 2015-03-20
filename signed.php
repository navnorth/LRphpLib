<?PHP

require dirname(__FILE__) . "/vendor/autoload.php";
require dirname(__FILE__) . "/Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig("C:/xampp/htdocs/learningregistry/config.txt");

$LR = new LearningRegistry\LearningRegistryServices\LearningRegistryPublish($LRConfig);
if($LR->checkNode()){
  if($LR->checkNodeActive()){
    
    $LR->setIdFields(
      array(
        'curator' => "info@pgogywebstuff.com",
        'owner' => "info@pgogywebstuff.com",
        'signer' => "info@pgogywebstuff.com",
        'submitter_type' => "user", 
        'submitter' => "info@pgogywebstuff.com"
      )
    );
    
    $LR->setResFields(
      array(
        'resource_locator' => "www.wibble.com",
        'resource_data_type' => 'metadata', 
        'active' => TRUE,
        //'replaces' => array('27a5d1852fb24d98bc731578d92cd155'),
        'submitter_timestamp' => "",
        'submitter_TTL' => "",
        'resource_TTL' => "",
        'payload_schema_locator' => "",
        //'payload_locator' => "here",
        'payload_schema_format' => "",
        'doc_type' => 'resource_data',
        'doc_version' => '0.49.0',
        'payload_placement' => 'attached',
        'payload_schema' => array('DC 1.1'),
        'resource_data' => htmlspecialchars_decode("package"),
        'keys' => array("hello")
      )
    );
    
    $LR->setSigFields(
      array(
        'signature'  => "",
        'key_server'  => "",
        'key_location'  => "",
        'key_owner'  => "",
        'signing_method'  => "",
      )
    );
    
    $LR->setTosFields(
      array(
        'tos_submission_attribution' => "",
        'submission_TOS' => "Standard",
      )
    );
    
    $LR->createDocument();
    //if($LR->verifyDocument()){
      $LR->signDocument();
      //if($LR->verifySignedDocument()){
        $LR->finaliseDocument();
        $LR->PublishService();
        $response = $LR->getDocData();
        $data = json_decode($response->response);
        print_r($data->document_results[0]->error);
      //}
    //}
    
  }else{
    print_r($LR->getResponse());
  }
}else{
  print_r($LR->getResponse());
}