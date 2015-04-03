<?PHP

require dirname(__FILE__) . "/../vendor/autoload.php";
require dirname(__FILE__) . "/../Psr4AutoloaderClass.php";

$LRConfig = new LearningRegistry\LearningRegistryConfig(
                                                           array(
														     "url" => "sandbox.learningregistry.org",
														     "username" => "info@pgogywebstuff.com",
														     "https" => 1,
														     "signing" => 1,
														     "password" => "",
														     "oauthSignature" => "",
														     "auth" => "oauth",
														     "keyPath" => "c:/users/Pat/AppData/Roaming/gnupg/pubring.gpg",
														     "publicKeyPath" => "http://www.pgogywebstuff.com/public_key.txt"
														   )
);

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
        'resource_locator' => "http://www.wibble.com",
        'resource_data_type' => 'metadata',
        'active' => TRUE,
        //'replaces' => array('27a5d1852fb24d98bc731578d92cd155'),
        'submitter_timestamp' => "",
        'submitter_TTL' => "",
        'resource_TTL' => "",
        'payload_schema_locator' => "",
        //'payload_locator' => "www.wibble.com",
        'payload_schema_format' => "",
        'doc_type' => 'resource_data',
        'doc_version' => '0.49.0',
        'payload_placement' => 'inline',
        'payload_schema' => array('DC 1.1'),
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
        //'tos_submission_attribution' => "",
        'submission_TOS' => "http://learningregistry.org/tos",
      )
    );

	$LR->setResFields(
		array(
			'resource_data' => htmlspecialchars_decode("I am some data"),
		)
	  );


    $LR->createDocument();
    if($LR->verifyDocument()){
	  $LR->signDocument();
	  if($LR->verifySignedDocument()){
	    $LR->finaliseDocument();
	    $LR->PublishService();
	    $response = $LR->getDocData();
	    print_r(json_decode($response->response));
	  }
    }

  }else{
    print_r($LR->getResponse());
  }
}else{
  print_r($LR->getResponse());
}
